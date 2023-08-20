<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Store;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Str;
use App\Models\GameServer;

class StoreController extends Controller
{
	public function index()
	{
		return view('dashboard.store', [
			'title' => 'Store',
			'subtitle' => 'Lihat semua toko yang anda miliki',
			'store' => Store::where('id_seller', AuthController::getJWT()->sub)->with('gameserver')->get(),
			'gameserver' => GameServer::where('id_seller', AuthController::getJWT()->sub)->get(),
		]);
	}

	public function create(Request $request)
	{
		$request->validate([
			'id_gameserver' => 'required|exists:gameservers,id',
			'name' => 'required|min:4|max:20|unique:stores,name',
			'description' => 'required|min:100|max:255',
			'domain' => 'required|min:4|max:20|regex:/^[a-zA-Z0-9]+$/',
			'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		// check if domain is taken
		$check_domain = Store::where('domain', $request->domain . '.' . env('STORE_DOMAIN'))->first();
		if($check_domain) {
			return redirect()->back()->withInput()->with('api_errors', 'Domain sudah digunakan');
		}

		// check if gameserver is owned by seller
		$check_gameserver = GameServer::where('id', $request->id_gameserver)->where('id_seller', AuthController::getJWT()->sub)->first();
		if(!$check_gameserver) {
			return redirect()->back()->withInput()->with('api_errors', 'Server tidak ditemukan');
		}

		// upload image to cdn.tokoqu.io/image using form-data
		$upload = Http::withToken(env('CDN_KEY'))->attach('file', file_get_contents($request->file('logo')), $request->file('logo')->getClientOriginalName())->post(env('CDN_URL').'/image')->json();

		if($upload['success'] == false) {
			return redirect()->route('dash.product')->withInput()->with('api_errors', 'Gagal mengunggah gambar');
		} 
		$img_url = $upload['data']['url'];

		Store::create([
			'id_seller' => AuthController::getJWT()->sub,
			'id_gameserver' => $request->id_gameserver,
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
			'logo' => $img_url,
			'api_key' => Str::uuid(),
		]);

		return redirect()->back()->with('success', 'Toko anda berhasil dibuat');
	}

	public function detail($id)
	{
		// get store where id = $id and id_seller = AuthController::getJWT()->sub
		$store = Store::where('id', $id)->where('id_seller', AuthController::getJWT()->sub)->first();
		return response()->json($store);
	}

	public function edit(Request $request, $id)
	{
		$rules_logo = $request->file('logo') ? 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' : '';
		$request->validate([
			'id_gameserver' => 'required|exists:gameservers,id',
			'name' => 'required|min:4|max:20|unique:stores,name,'.$id.',id',
			'description' => 'required|min:100|max:255',
			'domain' => 'required|min:4|max:20|regex:/^[a-zA-Z0-9]+$/',
			'logo' => $rules_logo,
		]);

		// check if new domain is is different from old domain
		$oldData = Store::where('id', $id)->first();
		if($oldData->domain != $request->domain . '.' . env('STORE_DOMAIN')) {
			// check if domain is taken
			$check_domain = Store::where('domain', $request->domain . '.' . env('STORE_DOMAIN'))->first();
			if($check_domain) {
				return redirect()->route('dash.store')->withInput()->with('api_errors', 'Domain sudah digunakan');
			}
		}

		// check if gameserver is owned by seller
		$check_gameserver = GameServer::where('id', $request->id_gameserver)->where('id_seller', AuthController::getJWT()->sub)->first();
		if(!$check_gameserver) {
			return redirect()->route('dash.store')->withInput()->with('api_errors', 'Server tidak ditemukan');
		}

		// check if new logo is uploaded
		if($request->file('logo')) {
			// upload image to cdn.tokoqu.io/image using form-data
			$upload = Http::withToken(env('CDN_KEY'))->attach('file', file_get_contents($request->file('logo')), $request->file('logo')->getClientOriginalName())->post(env('CDN_URL').'/image')->json();

			if($upload['success'] == false) {
				return redirect()->route('dash.product')->withInput()->with('api_errors', 'Gagal mengunggah gambar');
			}

			$img_url = $upload['data']['url'];
		}

		Store::where('id', $id)->update([
			'id_gameserver' => $request->id_gameserver,
			'name' => $request->name,
			'description' => $request->description,
			'domain' => $request->domain . '.' . env('STORE_DOMAIN'),
			'youtube' => $request->youtube ? $request->youtube : '-',
			'instagram' => $request->instagram ? $request->instagram : '-',
			'tiktok' => $request->tiktok ? $request->tiktok : '-',
			'discord' => $request->discord ? $request->discord : '-',
			'phone' => $request->phone ? $request->phone : '-',
			'facebook' => $request->facebook ? $request->facebook : '-',
			'logo' => $request->file('logo') ? $img_url : $oldData->logo,
		]);

		return redirect()->route('dash.store')->with('success', 'Toko anda berhasil di update');
	}

	public function delete($id)
	{
		$store = Store::where('id', $id)->first();
		$store->delete();

		return redirect()->route('dash.store')->with('success', 'Toko anda berhasil dihapus');
	}
}
