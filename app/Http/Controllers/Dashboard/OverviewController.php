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
		$transactions = Transactions::whereHas('store', function ($query) {
			$query->where('id_seller', AuthController::getJWT()->sub);
		})->get();
		$total_income = $transactions->sum('amount');

		$reviews = Reviews::whereHas('transaction', function ($query) {
			$query->whereHas('store', function ($query) {
				$query->where('id_seller', AuthController::getJWT()->sub);
			});
		})->limit(4)->get();

		return view('dashboard.overview', [
			'title' => 'Overview',
			'subtitle' => '',
			'transactions' => $transactions,
			'reviews' => Reviews::whereHas('transaction', function ($query) {
				$query->whereHas('store', function ($query) {
					$query->where('id_seller', AuthController::getJWT()->sub);
				});
			})->get(),
			'products' => Product::whereHas('store', function ($query) {
				$query->where('id_seller', AuthController::getJWT()->sub);
			})->get(),
			'total_income' => $total_income,
			'seller' => Sellers::where('id', AuthController::getJWT()->sub)->first(),
		]);
	}
}
