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

class TransactionController extends Controller
{
    public function index()
    {
        return view('dashboard.transaction', [
            'title' => 'Transaction',
            'subtitle' => 'Lihat semua transaksi yang anda dapatkan',
            'transactions' => Transactions::whereHas('store', function ($query) {
                $query->where('id_seller', AuthController::getJWT()->sub);
            })->where('status', '!=', 'UNPAID')->get(),
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
            return redirect()->back()->with('error', 'Transaksi sudah dibayar, tidak dapat dibatalkan');
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
        $transaction->status = 'refunded';
        $transaction->save();

        // check if transaction is not paid
        if(strtolower($transaction->status) == 'unpaid') {
            return redirect()->back()->with('error', 'Transaksi belum dibayar, tidak dapat direfund');
        }

        // check if transactions is already cleared
        if($transaction->cleared_at != null) {
            return redirect()->back()->with('error', 'Transaksi sudah selesai dalam proses kliring, tidak dapat direfund');
        }

        return redirect()->back()->with('success', 'Transaksi berhasil direfund');
    }

    public function resend($id)
    {
        // 
    }
}
