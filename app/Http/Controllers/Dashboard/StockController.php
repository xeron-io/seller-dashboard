<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class StockController extends Controller
{
	public function index()
	{
		return view('dashboard.stock', [
			'title' => 'Stock',
			'subtitle' => 'Lihat semua kategori yang toko anda miliki',
			'store' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/store')->json()['data'],
			'product' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/product')->json()['data'],
			'stock' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/stock?expired=false')->json()['data'],
			'stock_expire' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/stock?expired=true')->json()['data'],
		]);
	}

	public function detail($id)
	{
		$response = Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/stock/'.$id)->json()['data'];
		return $response;
	}

	public function create(Request $request)
	{
		$array = ['true', 'false'];
		$request->validate([
			'id_product' => 'required',
			'unlimited' => 'required|in:'.implode(',', $array),
			'stock_expire' => 'required|date',
			'stock_content' => 'required|min:100',
		]);

		$id_product = explode(';', $request->id_product)[0];
		$id_store = explode(';', $request->id_product)[1];

		$response = Http::withToken(session('token'))->post(env('BACKEND_URL').'/seller/stock', [
			'idProduct' => $id_product,
			'idStore' => $id_store,
			'isUnlimited' => $request->unlimited,
			'stockExpiredAt' => $request->stock_expire,
			'stockContent' => $request->stock_content,
		])->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.stock')->with('success', 'Stock anda berhasil dibuat');
		} else {
			return redirect()->route('dash.stock')->withInput()->with('api_errors', $response['errors']);
		}
	}

	public function edit(Request $request, $id)
	{
		$array = ['true', 'false'];
		$request->validate([
			'id_product' => 'required',
			'unlimited' => 'required|in:'.implode(',', $array),
			'stock_expire' => 'required|date',
			'stock_content' => 'required|min:100',
		]);

		$id_product = explode(';', $request->id_product)[0];
		$id_store = explode(';', $request->id_product)[1];

		$response = Http::withToken(session('token'))->put(env('BACKEND_URL').'/seller/stock/'. $id, [
			'idProduct' => $id_product,
			'idStore' => $id_store,
			'isUnlimited' => $request->unlimited,
			'stockExpiredAt' => $request->stock_expire,
			'stockContent' => $request->stock_content,
		])->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.stock')->with('success', 'Stock anda berhasil diubah');
		} else {
			return redirect()->route('dash.stock')->withInput()->with('api_errors', $response['errors']);
		}
	}

	public function delete($id)
	{
		$response = Http::withToken(session('token'))->delete(env('BACKEND_URL').'/seller/stock/'. $id)->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.stock')->with('success', 'Stock anda berhasil dihapus');
		} else {
			return redirect()->route('dash.stock')->withInput()->with('api_errors', $response['errors']);
		}
	}
}
