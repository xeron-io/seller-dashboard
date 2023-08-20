<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use App\Http\Controllers\AuthController;
use App\Models\Sellers;
use App\Models\Wallets;

class WithdrawController extends Controller
{
	const fee = 5000;

	public function index()
	{
		$wallet = Wallets::where('id_seller', AuthController::getJWT()->sub)->with('seller')->first();
		if (!$wallet) {
			return redirect()->route('dash.bank')->with('api_errors', 'Silahkan tambahkan rekening bank anda terlebih dahulu');
		}

		return view('dashboard.withdraw', [
			'title' => 'Penarikan Saldo',
			'subtitle' => 'Tarik saldo anda disini',
			'withdraw' => Withdraw::where('id_seller', AuthController::getJWT()->sub)->get(),
			'fee' => self::fee,
			'wallet' => $wallet,
		]);
	}

	public function create(Request $request)
	{
		$wallet = Wallets::where('id_seller', AuthController::getJWT()->sub)->with('seller')->first();
		$request->validate([
			'amount' => 'required|numeric|min:100000|max:10000000',
		]);

		// check if balance is enough
		if ($wallet->seller->balance < $request->amount) {
			return redirect()->back()->with('api_errors', 'Saldo anda tidak mencukupi');
		}

		$balance_after = $wallet->seller->balance - $request->amount;
		Withdraw::create([
			'id_seller' => AuthController::getJWT()->sub,
			'wallet_number' => $wallet->number,
			'wallet_code' => $wallet->code,
			'wallet_name' => $wallet->name,
			'wallet_owner' => $wallet->owner,
			'amount' => $request->amount,
			'fee' => self::fee,
			'balance_before' => $wallet->seller->balance,
			'balance_after' => $balance_after,
			'status' => 'pending',
		]);

		// update balance
		$wallet->seller->update([
			'balance' => $balance_after,
		]);

		return redirect()->back()->with('success', 'Permintaan penarikan saldo anda telah dikirim');
	}
}
