<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
	public function index()
	{
		return view('dashboard.category', [
			'title' => 'Category',
			'subtitle' => 'Lihat semua kategori yang toko anda miliki',
			'category' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/category')->json()['data'],
			'store' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/store')->json()['data'],
		]);
	}

	public function detail($id)
	{
		$response = Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/category/'.$id)->json();
		return $response;
	}

	public function filter($id)
	{
		$response = Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/category?store=' . $id)->json();
		return $response;
	}

	public function create(Request $request)
	{
		$request->validate([
			'category_name' => 'required|min:4',
			'category_description' => 'required|min:50',
			'id_store' => 'required',
		]);

		$response = Http::withToken(session('token'))->post(env('BACKEND_URL').'/seller/category', [
			'categoryName' => $request->category_name,
			'categoryDescription' => $request->category_description,
			'idStore' => $request->id_store,
		])->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.category')->with('success', 'Kategori anda berhasil dibuat');
		} else {
			return redirect()->route('dash.category')->withInput()->with('api_errors', $response['errors']);
		}
	}

	public function edit(Request $request, $id)
	{
		$request->validate([
			'category_name' => 'required|min:4',
			'category_description' => 'required|min:50',
			'id_store' => 'required',
		]);

		$response = Http::withToken(session('token'))->put(env('BACKEND_URL').'/seller/category/'.$id, [
			'categoryName' => $request->category_name,
			'categoryDescription' => $request->category_description,
			'idStore' => $request->id_store,
		])->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.category')->with('success', 'Kategori anda berhasil diubah');
		} else {
			return redirect()->route('dash.category')->withInput()->with('api_errors', $response['errors']);
		}
	}

	public function delete($id)
	{
		$response = Http::withToken(session('token'))->delete(env('BACKEND_URL').'/seller/category/'.$id)->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.category')->with('success', 'Kategori anda berhasil dihapus');
		} else {
			return redirect()->route('dash.category')->withInput()->with('api_errors', $response['errors']);
		}
	}
}
