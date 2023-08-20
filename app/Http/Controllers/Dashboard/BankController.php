<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use App\Models\Wallets;
use App\Http\Controllers\AuthController;

class BankController extends Controller
{
	public function index()
	{
		return view('dashboard.bank', [
			'title' => 'Rekening Bank',
			'subtitle' => 'Lihat rekening bank yang anda daftarkan disini',
			'wallet' => Wallets::where('id_seller', AuthController::getJWT()->sub)->first(),
			'banks' => json_decode(file_get_contents(base_path('/public/Assets/json/banks.json')), true),
		]);
	}

	public function create(Request $request)
	{
		$request->validate([
			'name' => 'required',
			'number' => 'required',
			'owner' => 'required',
		]);

		// split data from $request->name with delimiter ;
		$split = explode(';', $request->name);

		Wallets::create([
			'id_seller' => AuthController::getJWT()->sub,
			'name' => $split[1],
			'code' => $split[0],
			'number' => $request->number,
			'owner' => ucwords($request->owner),
		]);

		return redirect()->back()->with('success', 'Berhasil menambahkan rekening bank');
	}
}
