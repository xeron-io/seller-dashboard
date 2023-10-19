<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use App\Models\Transactions;
use App\Models\Store;
use App\Http\Controllers\AuthController;
use App\Models\ClaimLog;

class TransactionController extends Controller
{
    public function index()
    {
        return view('dashboard.transaction', [
            'title' => 'Transaction',
            'subtitle' => 'Lihat semua transaksi yang anda dapatkan',
            'transactions' => Transactions::whereHas('store', function ($query) {
                $query->where('id_seller', AuthController::getJWT()->sub);
            })->where('status', '!=', 'UNPAID')->where('status', '!=', 'EXPIRED')->get(),
            'store' => Store::where('id_seller', AuthController::getJWT()->sub)->get(),
        ]);
    }

    public function detail($id)
    {
        $transaction = Transactions::where('id', $id)->whereHas('store', function ($query) {
            $query->where('id_seller', AuthController::getJWT()->sub);
        })->with('store')->with('product')->first();
        return response()->json($transaction);
    }

    public function cancel($id)
    {
        $transaction = Transactions::where('id', $id)->whereHas('store', function ($query) {
            $query->where('id_seller', AuthController::getJWT()->sub);
        })->first();

        // check if transaction is already paid
        if(strtolower($transaction->status) == 'paid') {
            return redirect()->back()->with('api_errors', 'Transaksi sudah dibayar, tidak dapat dibatalkan');
        }

        $transaction->status = 'canceled';
        $transaction->save();

        return redirect()->back()->with('success', 'Transaksi berhasil dibatalkan');
    }

    public function refund($id)
    {
        $transaction = Transactions::where('id', $id)->whereHas('store', function ($query) {
            $query->where('id_seller', AuthController::getJWT()->sub);
        })->first();

        // check if transaction is not paid
        if(strtolower($transaction->status) != 'paid') {
            return redirect()->back()->with('api_errors', 'Transaksi harus berstatus paid untuk dapat direfund');
        }

        // check if transactions is already cleared
        if($transaction->cleared_at != null) {
            return redirect()->back()->with('api_errors', 'Transaksi sudah selesai dalam proses kliring, tidak dapat direfund');
        }

        $transaction->status = 'pending_refund';
        $transaction->save();
        return redirect()->back()->with('success', 'Transaksi berhasil direfund');
    }

    public function resend($id)
    {
        $transaction = Transactions::where('id', $id)->where('status', 'paid')->whereHas('store', function ($query) {
            $query->where('id_seller', AuthController::getJWT()->sub);
        })->first();
        if($transaction == null) {
            return redirect()->back()->with('api_errors', 'Transaksi tidak ditemukan');
        }
        
        ClaimLog::where('id_transaction', $id)->delete();
        return redirect()->back()->with('success', 'Transaksi berhasil dikirim ulang');
    }
}
