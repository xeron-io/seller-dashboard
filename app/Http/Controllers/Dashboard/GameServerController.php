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

	public function ping($ip, $port)
	{
		$pf = @fsockopen($ip, $port, $err, $err_string, 1);
		if (!$pf) {
			return response()->json([
				'status' => 'offline',
				'message' => 'Connection failed.'
			]);
		} else {
			return response()->json([
					'status' => 'online',
					'message' => 'Connection success.'
			]);
		}
	}

	public function detail($id)
	{
		$gameserver = GameServer::where('id_seller', AuthController::getJWT()->sub)->where('id', $id)->first();
		return response()->json($gameserver);
	}

	public function create(Request $request)
	{
		$rules_domain = $request->domain ? 'required|string|min:3|max:255' : 'nullable';
		$request->validate([
			'name' => 'required|string|min:3|max:255',
			'game' => 'required|string|max:255',
			'ip' => 'required|string|max:255',
			'port' => 'required|string|max:25',
			'domain' => $rules_domain,
		]);

		$gameserver = GameServer::create([
			'id_seller' => AuthController::getJWT()->sub,
			'name' => $request->name,
			'game' => $request->game,
			'ip' => $request->ip,
			'port' => $request->port,
			'domain' => $request->domain ? $request->domain : null,
		]);

		return redirect()->back()->with('success', 'Berhasil menambahkan game server baru');
	}

	public function edit(Request $request, $id)
	{
		$request->validate([
			'name' => 'required|string|min:3|max:255',
			'game' => 'required|string|max:255',
			'ip' => 'required|string|max:255',
			'port' => 'required|string|max:25',
			'domain' => 'nullable|string|max:255',
		]);

		GameServer::where('id_seller', AuthController::getJWT()->sub)->where('id', $id)->update([
			'name' => $request->name,
			'game' => $request->game,
			'ip' => $request->ip,
			'port' => $request->port,
			'domain' => $request->domain ? $request->domain : null,
		]);

		return redirect()->back()->with('success', 'Berhasil mengupdate game server');
	}

	public function delete($id)
	{
		GameServer::where('id_seller', AuthController::getJWT()->sub)->where('id', $id)->delete();
		return redirect()->back()->with('success', 'Berhasil menghapus game server');
	}
}
