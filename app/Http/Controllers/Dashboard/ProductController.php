<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\AuthController;

class ProductController extends Controller
{
	public function index()
	{
		$store = Store::where('id_seller', AuthController::getJWT()->sub)->get();
		$category = Category::whereHas('store', function($q) {
			$q->where('id_seller', AuthController::getJWT()->sub);
		})->get();
		$product = Product::whereHas('store', function($q) {
			$q->where('id_seller', AuthController::getJWT()->sub);
		})->get();

		return view('dashboard.product', [
			'title' => 'Product',
			'subtitle' => 'Lihat semua produk yang toko anda miliki',
			'product' => $product,
			'store' => $store,
			'category' => $category,
		]);
	}

	public function detail($id)
	{
		$product = Product::where('id', $id)->whereHas('store', function($q) {
			$q->where('id_seller', AuthController::getJWT()->sub);
		})->first();
		return response()->json($product);
	}

	public function create(Request $request)
	{
		$request->validate([
			'id_category' => 'required|exists:category,id',
			'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
			'name' => 'required|string|min:3',
			'price' => 'required|numeric|min:10000',
			'description' => 'required|string|min:100',
			'ingame_command' => 'required|string',
		]);

		$category = Category::where('id', $request->id_category)->whereHas('store', function($q) {
			$q->where('id_seller', AuthController::getJWT()->sub);
		})->first();

		// upload image to cdn.tokoqu.io/image using form-data
		$upload = Http::withToken(env('CDN_KEY'))->attach('file', file_get_contents($request->file('image')), $request->file('image')->getClientOriginalName())->post(env('CDN_URL').'/image')->json();

		if($upload['success'] == false) {
			return redirect()->route('dash.product')->withInput()->with('api_errors', 'Gagal mengunggah gambar');
		} 
		$img_url = $upload['data']['url'];

		Product::create([
			'id_category' => $category->id,
			'id_store' => $category->id_store,
			'name' => $request->name,
			'slug' => Str::slug($request->name),
			'description' => $request->description,
			'price' => $request->price,
			'image' => $img_url,
			'ingame_command' => $request->ingame_command,
		]);

		return redirect()->route('dash.product')->with('success', 'Produk berhasil ditambahkan');
	}

	public function edit(Request $request, $id)
	{
		$rules_image = $request->file('image') ? 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048' : '';
		$request->validate([
			'id_category' => 'required|exists:category,id',
			'image' => $rules_image,
			'name' => 'required|string|min:3',
			'price' => 'required|numeric|min:10000',
			'description2' => 'required|string|min:100',
			'ingame_command' => 'required|string',
		]);

		$category = Category::where('id', $request->id_category)->whereHas('store', function($q) {
			$q->where('id_seller', AuthController::getJWT()->sub);
		})->first();
		$oldData = Product::where('id', $id)->whereHas('store', function($q) {
			$q->where('id_seller', AuthController::getJWT()->sub);
		})->first();

		// check if new image is uploaded
		if($request->file('image')) {
			// upload image to cdn.tokoqu.io/image using form-data
			$upload = Http::withToken(env('CDN_KEY'))->attach('file', file_get_contents($request->file('image')), $request->file('image')->getClientOriginalName())->post(env('CDN_URL').'/image')->json();

			if($upload['success'] == false) {
				return redirect()->route('dash.product')->withInput()->with('api_errors', 'Gagal mengunggah gambar');
			} 
			$img_url = $upload['data']['url'];
		}

		Product::where('id', $id)->update([
			'id_category' => $category->id,
			'id_store' => $category->id_store,
			'name' => $request->name,
			'slug' => Str::slug($request->name, '-'),
			'description' => $request->description2,
			'price' => $request->price,
			'image' => $request->file('image') ? $img_url : $oldData->image,
			'ingame_command' => $request->ingame_command,
		]);

		return redirect()->route('dash.product')->with('success', 'Produk berhasil diubah');
	}

	public function delete($id)
	{
		$product = Product::where('id', $id)->whereHas('store', function($q) {
			$q->where('id_seller', AuthController::getJWT()->sub);
		})->delete();

		return redirect()->route('dash.product')->with('success', 'Produk berhasil dihapus');
	}
}
