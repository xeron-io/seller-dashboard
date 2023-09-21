<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Models\Store;
use App\Models\Reviews;

class ReviewController extends Controller
{
	public function index()
	{
		return view('dashboard.review', [
			'title' => 'Reviews',
			'subtitle' => 'Lihat semua review yang anda dapatkan',
			'reviews' => Reviews::whereHas('transaction', function ($query) {
				$query->whereHas('store', function ($query) {
					$query->where('id_seller', AuthController::getJWT()->sub);
				});
			})->with('transaction')->with('transaction.store')->with('transaction.product')->get(),
			'store' => Store::where('id_seller', AuthController::getJWT()->sub)->get(),
		]);
	}
}
