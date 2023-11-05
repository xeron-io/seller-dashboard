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
		$store = Store::where('id_seller', AuthController::getJWT()->sub)->first();
		$domain = explode('.', $store->domain);

		return view('wizzard.step2', [
			'title' => 'Setup Your Store',
			'gameserver' => GameServer::where('id_seller', AuthController::getJWT()->sub)->first(),
			'store' => $store,
			'domain' => $domain[0],
		]);
	}

	public function step3()
	{
		$store = Store::where('id_seller', AuthController::getJWT()->sub)->first();
		if (!$store) {
			return redirect()->route('dash.step1');
		}

		return view('wizzard.step3', [
			'title' => 'Configure Your Server',
			'store' => $store,
		]);
	}

	public function step4()
	{
		return view('wizzard.step4', [
			'title' => 'Setup Your Store',
		]);
	}
}