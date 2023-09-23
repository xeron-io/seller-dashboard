<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use App\Models\Reviews;
use App\Http\Controllers\AuthController;
use App\Models\Product;
use App\Models\Sellers;

class OverviewController extends Controller
{
	public function index()
	{
		$transactions = Transactions::where('status', 'PAID')->whereHas('store', function ($query) {
			$query->where('id_seller', AuthController::getJWT()->sub);
		})->get();
		$total_income = $transactions->sum('amount_bersih');
		$not_yet_cleared = $transactions->where('cleared_at', null)->sum('amount_bersih');

		$reviews = Reviews::whereHas('transaction', function ($query) {
			$query->whereHas('store', function ($query) {
				$query->where('id_seller', AuthController::getJWT()->sub);
			});
		})->limit(4)->get();

		return view('dashboard.overview', [
			'title' => 'Overview',
			'subtitle' => '',
			'transactions' => $transactions,
			'reviews' => $reviews,
			'total_income' => $total_income,
			'not_yet_cleared' => $not_yet_cleared,
			'seller' => Sellers::where('id', AuthController::getJWT()->sub)->first(),
		]);
	}

	public function getTransactions()
	{
		$transactions = Transactions::whereHas('store', function ($query) {
			$query->where('id_seller', AuthController::getJWT()->sub);
		})->get();

		// get transaction of the year per month (jan - dec) and if there is no transaction in a month, it will be 0
		$transaction_categorized = [];
		for ($i = 1; $i <= 12; $i++) {
			$transaction_categorized[$i] = 0;
		}

		foreach ($transactions as $transaction) {
			$transaction_categorized[$transaction->created_at->month] += 1;
		}

		$transaction_of_the_year = [];
		foreach ($transaction_categorized as $key => $value) {
			$transaction_of_the_year[] = [
				'month' => date('F', mktime(0, 0, 0, $key, 10)),
				'total' => $value
			];
		}

		return response()->json($transaction_of_the_year);
	}
}
