<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SetupController extends Controller
{
	public function index()
	{
		return view('wizzard.step1', [
			'title' => 'Setup Your Account',
		]);
	}
}
