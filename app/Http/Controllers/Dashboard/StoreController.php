<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use App\Models\Store;
use App\Http\Controllers\AuthController;

class StoreController extends Controller
{
	public function index()
	{
		return view('dashboard.store', [
			'title' => 'Store',
			'subtitle' => 'Lihat semua toko yang anda miliki',
			'store' => Store::where('id_seller', AuthController::getJWT()->sub)->get(),
		]);
	}

	public function create(Request $request)
	{
		$request->validate([
			'name' => 'required|min:4|max:20|unique:stores,name',
			'description' => 'required|min:100',
			'domain' => 'required|min:4',
			'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		// check if domain is taken
		$check_domain = Store::where('domain', $request->domain . '.' . env('STORE_DOMAIN'))->first();
		if($check_domain) {
			return redirect()->route('dash.store')->withInput()->with('api_errors', 'Domain sudah digunakan');
		}

		// // upload image to cdn.tokoqu.io/image using form-data
		// $upload = Http::withToken(env('CDN_KEY'))->attach('file', file_get_contents($request->file('logo')), $request->file('logo')->getClientOriginalName())->post(env('CDN_URL').'/image')->json();

		// if($upload['success'] == false) {
		// 	return redirect()->route('dash.product')->withInput()->with('api_errors', 'Gagal mengunggah gambar');
		// } 
		// $img_url = $upload['data']['url'];

		Store::create([
			'id_seller' => AuthController::getJWT()->sub,
			'id_theme' => env('DEFAULT_THEME_ID'),
			'name' => $request->name,
			'description' => $request->description,
			'domain' => $request->domain . '.' . env('STORE_DOMAIN'),
			'youtube' => $request->youtube ? $request->youtube : '-',
			'instagram' => $request->instagram ? $request->instagram : '-',
			'tiktok' => $request->tiktok ? $request->tiktok : '-',
			'discord' => $request->discord ? $request->discord : '-',
			'phone' => $request->phone ? $request->phone : '-',
			'facebook' => $request->facebook ? $request->facebook : '-',
			'status' => 'pending', // 'pending', 'active', 'suspended
			'logo' => 'test.io', // $img_url,
		]);

		return redirect()->route('dash.store')->with('success', 'Toko anda berhasil dibuat');
	}

	public function edit($id)
	{
		$response = Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/store/'.$id)->json()['data'];
		return view('dashboard.store_edit', [
			'title' => 'Store',
			'subtitle' => 'Edit toko anda yang anda miliki ' . '(' . $response['store_name'] . ')',
			'store' => $response,
			'store_domain' => explode('.', $response['domain'])[0],
		]);
	}

	public function theme($id)
	{
		$store = Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/store/'.$id)->json()['data'];
		return view('dashboard.store_theme', [
			'title' => 'Store',
			'subtitle' => 'Edit tema toko anda yang anda miliki ' . '(' . $store['store_name'] . ')',
			'store' => $store,
			'themes' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/theme')->json()['data'],
		]);
	}

	public function edit_store(Request $request, $id)
	{
		$request->validate([
			'store_name' => 'required|min:4',
			'store_description' => 'required|min:100',
			'domain' => 'required|min:4',
		]);

		$response = Http::withToken(session('token'))->put(env('BACKEND_URL').'/seller/store/' . $id, [
			'idTheme' => env('DEFAULT_THEME_ID'),
			'storeName' => $request->store_name,
			'storeDescription' => $request->store_description,
			'domain' => $request->domain . '.' . env('STORE_DOMAIN'),
			'youtube' => $request->youtube,
			'instagram' => $request->instagram,
			'tiktok' => $request->tiktok,
			'discord' => $request->discord,
			'phone' => $request->phone,
		])->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.store')->with('success', 'Perubahan toko anda berhasil disimpan');
		} else {
			return redirect()->route('dash.store')->withInput()->with('api_errors', $response['errors'] ? $response['errors'] : $response['message']);
		}
	}

	public function theme_save(Request $request, $id)
	{
		$request->validate([
			'id_theme' => 'required',
		]);

		$oldData = Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/store/'.$id)->json()['data'];

		$response = Http::withToken(session('token'))->put(env('BACKEND_URL').'/seller/store/' . $id, [
			'idTheme' => $request->id_theme,
			'storeName' => $oldData['store_name'],
			'storeDescription' => $oldData['store_description'],
			'domain' => $oldData['domain'],
			'youtube' => $oldData['youtube'],
			'instagram' => $oldData['instagram'],
			'tiktok' => $oldData['tiktok'],
			'discord' => $oldData['discord'],
			'phone' => $oldData['phone'],
		])->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.store')->with('success', 'Theme toko anda berhasil disimpan');
		} else {
			return redirect()->route('dash.store')->withInput()->with('api_errors', $response['errors'] ? $response['errors'] : $response['message']);
		}
	}

	public function delete($id)
	{
		$response = Http::withToken(session('token'))->delete(env('BACKEND_URL').'/seller/store/'.$id)->json();

		if($response['success'] == 'true') {
			return redirect()->route('dash.store')->with('success', 'Toko anda berhasil dihapus');
		} else {
			return redirect()->route('dash.store')->withInput()->with('api_errors', $response['errors'] ? $response['errors'] : $response['message']);
		}
	}
}
