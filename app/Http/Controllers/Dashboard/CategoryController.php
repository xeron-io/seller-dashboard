<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Category;
use App\Models\Store;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
	public function index()
	{
		$store = Store::where('id_seller', AuthController::getJWT()->sub)->get();
		// get category who belongs to AuthController::getJWT()->sub using Relationship
		$category = Category::whereHas('store', function($q) {
			$q->where('id_seller', AuthController::getJWT()->sub);
		})->get();
		
		return view('dashboard.category', [
			'title' => 'Category',
			'subtitle' => 'Lihat semua kategori yang toko anda miliki',
			'category' => $category,
			'store' => $store,
		]);
	}

	public function detail($id)
	{
		// get category where id = $id and id_store = AuthController::getJWT()->sub
		$category = Category::where('id', $id)->whereHas('store', function($q) {
			$q->where('id_seller', AuthController::getJWT()->sub);
		})->first();
		return response()->json($category);
	}

	public function create(Request $request)
	{
		$request->validate([
			'id_store' => 'required|exists:stores,id',
			'name' => 'required|min:3|max:50',
			'description' => 'required|min:30|max:255',
		]);

		// check if id_store is belongs to AuthController::getJWT()->sub
		$store = Store::where('id', $request->id_store)->where('id_seller', AuthController::getJWT()->sub)->first();
		if(!$store) {
			return redirect()->back()->with('api_errors', 'Toko tidak ditemukan');
		}

		Category::create([
			'id_store' => $store->id,
			'name' => $request->name,
			'slug' => Str::slug($request->name),
			'description' => $request->description,
		]);

		return redirect()->route('dash.category')->with('success', 'Kategori anda berhasil ditambahkan');
	}

	public function edit(Request $request, $id)
	{
		$request->validate([
			'id_store' => 'required|exists:stores,id',
			'name' => 'required|min:3|max:50',
			'description' => 'required|min:30|max:255',
		]);

		// check if id_store is belongs to AuthController::getJWT()->sub
		$store = Store::where('id', $request->id_store)->where('id_seller', AuthController::getJWT()->sub)->first();
		if(!$store) {
			return redirect()->back()->with('api_errors', 'Toko tidak ditemukan');
		}

		$category = Category::where('id', $id)->whereHas('store', function($q) {
			$q->where('id_seller', AuthController::getJWT()->sub);
		})->first();
		if(!$category) {
			return redirect()->back()->with('api_errors', 'Kategori tidak ditemukan');
		}

		$category->update([
			'id_store' => $request->id_store,
			'name' => $request->name,
			'slug' => Str::slug($request->name),
			'description' => $request->description,
		]);

		return redirect()->route('dash.category')->with('success', 'Kategori anda berhasil di update');
	}

	public function delete($id)
	{
		$category = Category::where('id', $id)->whereHas('store', function($q) {
			$q->where('id_seller', AuthController::getJWT()->sub);
		})->first();

		if(!$category) {
			return redirect()->back()->with('api_errors', 'Kategori tidak ditemukan');
		}
		
		$category->delete();

		return redirect()->route('dash.category')->with('success', 'Kategori anda berhasil dihapus');
	}
}
