<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class OverviewController extends Controller
{
	public function index()
	{
		// return Inertia::render('Dashboard/Overview', [
		// 	'title' => 'Overview',
		// ]);

		return view('dashboard.overview', [
			'title' => 'Overview',
			'subtitle' => ''
		]);
	}
}
