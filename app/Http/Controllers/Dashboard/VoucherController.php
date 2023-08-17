<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class VoucherController extends Controller
{
	public function index()
	{
		return view('dashboard.voucher', [
			'title' => 'Voucher',
			'subtitle' => 'Lihat semua voucher yang toko anda miliki',
			'store' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/store')->json()['data'],
			'product' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/product')->json()['data'],
			'voucher' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/coupon?expired=false')->json()['data'],
			'voucher_expire' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/coupon?expired=true')->json()['data'],
		]);
	}

	public function detail($id)
	{
		$response = Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/coupon/'.$id)->json()['data'];
		return $response;
	}

	public function create(Request $request)
	{
		$type = ['percent', 'fixed'];
		$request->validate([
			'id_product' => 'required',
			'coupon_code' => 'required',
			'coupon_type' => 'required|in:'.implode(',', $type),
			'coupon_amount' => 'required|numeric',
			'coupon_expire' => 'required|date',
		]);

		$id_product = explode(';', $request->id_product)[0];
		$id_store = explode(';', $request->id_product)[1];

		$response = Http::withToken(session('token'))->post(env('BACKEND_URL').'/seller/coupon', [
			'idProduct' => $id_product,
			'idStore' => $id_store,
			'couponCode' => $request->coupon_code,
			'couponType' => $request->coupon_type,
			'couponAmount' => $request->coupon_amount,
			'couponExpiredAt' => $request->coupon_expire,
		])->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.voucher')->with('success', 'Voucher anda berhasil dibuat');
		} else {
			return redirect()->route('dash.voucher')->withInput()->with('api_errors', $response['errors']);
		}
	}

	public function edit(Request $request, $id)
	{
		$type = ['percent', 'fixed'];
		$request->validate([
			'id_product' => 'required',
			'coupon_code' => 'required',
			'coupon_type' => 'required|in:'.implode(',', $type),
			'coupon_amount' => 'required|numeric',
			'coupon_expire' => 'required|date',
		]);

		$id_product = explode(';', $request->id_product)[0];
		$id_store = explode(';', $request->id_product)[1];

		$response = Http::withToken(session('token'))->put(env('BACKEND_URL').'/seller/coupon/'.$id, [
			'idProduct' => $id_product,
			'idStore' => $id_store,
			'couponCode' => $request->coupon_code,
			'couponType' => $request->coupon_type,
			'couponAmount' => $request->coupon_amount,
			'couponExpiredAt' => $request->coupon_expire,
		])->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.voucher')->with('success', 'Voucher anda berhasil diubah');
		} else {
			return redirect()->route('dash.voucher')->withInput()->with('api_errors', $response['errors']);
		}
	}

	public function delete($id)
	{
		$response = Http::withToken(session('token'))->delete(env('BACKEND_URL').'/seller/coupon/'.$id)->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.voucher')->with('success', 'Voucher anda berhasil dihapus');
		} else {
			return redirect()->route('dash.voucher')->withInput()->with('api_errors', $response['errors']);
		}
	}
}
