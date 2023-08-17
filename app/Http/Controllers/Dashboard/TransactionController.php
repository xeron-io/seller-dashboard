<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/transaction')->json()['data'];
        $store = Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/store')->json()['data'];

        return view('dashboard.transaction', [
            'title' => 'Transaction',
            'subtitle' => 'Lihat semua transaksi yang anda dapatkan',
            'transactions' => $transactions,
            'store' => $store,
        ]);
    }

    public function cancel($id)
    {
        // code here
    }
}
