<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ProductController extends Controller
{
	public function index()
	{
		return view('dashboard.product', [
			'title' => 'Product',
			'subtitle' => 'Lihat semua produk yang toko anda miliki',
			'product' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/product')->json()['data'],
			'store' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/store')->json()['data'],
			'category' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/category')->json()['data'],
		]);
	}

	public function detail($id)
	{
		$response = Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/product/'.$id)->json()['data'];
		return $response;
	}

	public function create(Request $request)
	{
		$request->validate([
			'id_category' => 'required',
			'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
			'product_name' => 'required|string|min:3',
			'product_price' => 'required|numeric|min:5000',
			'product_description' => 'required|string|min:100',
			'min_quantity' => 'required|numeric|min:1',
		]);

		$id_category = explode(';', $request->id_category)[0];
		$id_store = explode(';', $request->id_category)[1];
		$product_slug = Str::slug($request->product_name, '-');

		// upload image to cdn.tokoqu.io/image using form-data
		$upload = Http::withToken(env('CDN_KEY'))->attach('file', file_get_contents($request->file('product_image')), $request->file('product_image')->getClientOriginalName())->post(env('CDN_URL').'/image')->json();

		if($upload['success'] == false) {
			return redirect()->route('dash.product')->withInput()->with('api_errors', 'Gagal mengunggah gambar');
		} 
		$img_url = $upload['data']['url'];

		$response = Http::withToken(session('token'))->post(env('BACKEND_URL').'/seller/product', [
			'idCategory' => $id_category,
			'idStore' => $id_store,
			'productName' => $request->product_name,
			'productSlug' => $product_slug,
			'productDescription' => $request->product_description,
			'productPrice' => $request->product_price,
			'productImage' => $img_url,
			'minQuantity' => $request->min_quantity,
		])->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.product')->with('success', 'Produk anda berhasil dibuat');
		} else {
			return redirect()->route('dash.product')->withInput()->with('api_errors', $response['errors']);
		}
	}

	public function edit(Request $request, $id)
	{
		$oldData = Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/product/'.$id)->json()['data'];
		$request->file('product_image') ? $rules_img = 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120' : $rules_img = '';
		$request->validate([
			'id_category' => 'required',
			'product_image' => $rules_img,
			'product_name' => 'required|string|min:3',
			'product_price' => 'required|numeric|min:5000',
			'product_description' => 'required|string|min:100',
			'min_quantity' => 'required|numeric|min:1',
		]);

		$id_category = explode(';', $request->id_category)[0];
		$id_store = explode(';', $request->id_category)[1];
		$product_slug = Str::slug($request->product_name, '-');
		$img_url = '';

		if($request->file('product_image')) {
			// upload image to cdn.tokoqu.io/image using form-data
			$upload = Http::withToken(env('CDN_KEY'))->attach('file', file_get_contents($request->file('product_image')), $request->file('product_image')->getClientOriginalName())->post(env('CDN_URL').'/image')->json();

			if($upload['success'] == false) {
				return redirect()->route('dash.product')->withInput()->with('api_errors', 'Gagal mengunggah gambar');
			}
			$img_url = $upload['data']['url'];
		}
		else {
			$img_url = $oldData['product_image'];
		}

		$response = Http::withToken(session('token'))->put(env('BACKEND_URL').'/seller/product/'.$id, [
			'idCategory' => $id_category,
			'idStore' => $id_store,
			'productName' => $request->product_name,
			'productSlug' => $product_slug,
			'productDescription' => $request->product_description,
			'productPrice' => $request->product_price,
			'productImage' => $img_url,
			'minQuantity' => $request->min_quantity,
		])->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.product')->with('success', 'Produk anda berhasil diubah');
		} else {
			return redirect()->route('dash.product')->withInput()->with('api_errors', $response['errors']);
		}
	}

	public function delete($id)
	{
		$response = Http::withToken(session('token'))->delete(env('BACKEND_URL').'/seller/product/'.$id)->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.product')->with('success', 'Produk anda berhasil dihapus');
		} else {
			return redirect()->route('dash.product')->withInput()->with('api_errors', $response['errors']);
		}
	}
}
