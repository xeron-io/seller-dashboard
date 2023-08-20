<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GameServer;
use Illuminate\Support\Str;
use App\Models\Store;
use App\Http\Controllers\AuthController;

class SetupController extends Controller
{
	public function step1()
	{
		$gameserver = GameServer::where('id_seller', AuthController::getJWT()->sub)->first();
		return view('wizzard.step1', [
			'title' => 'Setup Your Account',
			'gameserver' => $gameserver,
		]);
	}

	public function step2()
	{
		$gameserver = GameServer::where('id_seller', AuthController::getJWT()->sub)->first();
		if (!$gameserver) {
			return redirect()->route('dash.step1');
		}

		return view('wizzard.step2', [
			'title' => 'Setup Your Store',
			'gameserver' => $gameserver,
		]);
	}

	public function step3()
	{
		$store = Store::where('id_seller', AuthController::getJWT()->sub)->first();
		if ($store) {
			return redirect()->route('dash.setup4');
		}

		return view('wizzard.step3', [
			'title' => 'Setup Your Store',
			'gameserver' => GameServer::where('id_seller', AuthController::getJWT()->sub)->first(),
		]);
	}

	public function step4()
	{
		return view('wizzard.step4', [
			'title' => 'Setup Your Store',
		]);
	}
}
