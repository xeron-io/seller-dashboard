<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Models\GameServer;
use Illuminate\Support\Str;

class GameServerController extends Controller
{
	public function index()
	{
		$gameserver = GameServer::where('id_seller', AuthController::getJWT()->sub)->get();
		return view('dashboard.gameserver', [
			'title' => 'Game Server',
			'subtitle' => 'Lihat semua game server yang anda miliki',
			'gameserver' => $gameserver,
		]);
	}

	public function detail($id)
	{
		$gameserver = GameServer::where('id_seller', AuthController::getJWT()->sub)->where('id', $id)->first();
		return response()->json($gameserver);
	}

	public function create(Request $request)
	{
		$request->validate([
			'name' => 'required|string|min:3|max:255',
			'game' => 'required|string|max:255',
			'ip' => 'required|string|max:255',
			'port' => 'required|string|max:25'
		]);

		GameServer::create([
			'id_seller' => AuthController::getJWT()->sub,
			'name' => $request->name,
			'game' => $request->game,
			'ip' => $request->ip,
			'port' => $request->port,
			'api_key' => Str::uuid()
		]);

		return redirect()->back()->with('success', 'Berhasil menambahkan game server baru');
	}

	public function edit(Request $request, $id)
	{
		
	}

	public function delete($id)
	{
		
	}
}
