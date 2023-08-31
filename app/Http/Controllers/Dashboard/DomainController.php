<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use App\Http\Controllers\AuthController;
use App\Models\Store;

class DomainController extends Controller
{
	public function index()
	{
		return view('dashboard.domain', [
			'title' => 'Custom Domain',
			'subtitle' => 'Konfigurasi custom domain anda disini',
			'domain' => Store::where('id_seller', AuthController::getJWT()->sub)->whereNotNull('custom_domain')->get(),
			'store' => Store::where('id_seller', AuthController::getJWT()->sub)->get(),
		]);
	}

	public function create(Request $request)
	{
		$request->validate([
			'id_store' => 'required|numeric|exists:stores,id',
			'domain' => 'required|min:4|max:20|regex:/^[a-zA-Z0-9.-]+$/|unique:stores,custom_domain',
		]);

		$store = Store::where('id_seller', AuthController::getJWT()->sub)->where('id', $request->id_store)->first();
		if(!$store) {
			return redirect()->back()->with('api_errors', 'Toko tidak ditemukan');
		}

		if($store->custom_domain) {
			return redirect()->back()->with('api_errors', 'Toko sudah memiliki custom domain, silahkan hapus terlebih dahulu');
		}

		$store->update([
			'custom_domain' => strtolower($request->domain),
		]);

		return redirect()->back()->with('success', 'Berhasil menambahkan custom domain');
	}

	public function delete($id)
	{
		$store = Store::where('id_seller', AuthController::getJWT()->sub)->where('id', $id)->first();
		if(!$store) {
			return redirect()->back()->with('api_errors', 'Toko tidak ditemukan');
		}

		$store->update([
			'custom_domain' => null,
		]);

		return redirect()->back()->with('success', 'Berhasil menghapus custom domain');
	}
}
