<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class BankController extends Controller
{
	public function index()
	{
		return view('dashboard.bank', [
			'title' => 'Rekening Bank',
			'subtitle' => 'Lihat rekening bank yang anda daftarkan disini',
			'bank' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/withdraw/bank')->json()['data'],
		]);
	}

	public function create(Request $request)
	{
		$request->validate([
			'bankName' => 'required',
			'bankAccountNumber' => 'required',
			'bankAccountOwner' => 'required',
		]);

		$response = Http::withToken(session('token'))->post(env('BACKEND_URL').'/seller/withdraw/bank', [
			'bankName' => $request->bankName,
			'bankAccountNumber' => $request->bankAccountNumber,
			'bankAccountOwner' => $request->bankAccountOwner,
		])->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.bank')->with('success', 'Rekening Bank anda berhasil ditambahkan');
		} else {
			return redirect()->route('dash.bank')->withInput()->with('api_errors', $response['errors']);
		}
	}
}
