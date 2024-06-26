<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Themes;
use App\Http\Controllers\AuthController;

class ThemesController extends Controller
{
    public function index()
	{
		return view('dashboard.themes', [
			'title' => 'Custom Themes',
			'subtitle' => 'Ganti tema website anda disini',
			'themes' => Themes::all(),
            'store' => Store::where('id_seller', AuthController::getJWT()->sub)->get(),
		]);
	}

    public function activate(Request $request, $id_theme)
    {
        $store = Store::where('id', $request->id_store)->where('id_seller', AuthController::getJWT()->sub)->first();
        if(!$store) {
            return redirect()->back()->with('api_errors', 'Toko tidak ditemukan');
        }

        $theme = Themes::where('id', $id_theme)->first();
        if(!$theme) {
            return redirect()->back()->with('api_errors', 'Tema tidak ditemukan');
        }

        $store->update([
            'id_theme' => $theme->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil mengganti tema');
    }

    public function filter(Request $request)
    {
        $request->validate([
            'id_store' => 'required|exists:stores,id',
        ]);

        $store = Store::where('id', $request->id_store)->where('id_seller', AuthController::getJWT()->sub)->first();
        if(!$store) {
            return redirect()->back()->with('api_errors', 'Toko tidak ditemukan');
        }

        // return as json
        return response()->json($store);

    }
}
