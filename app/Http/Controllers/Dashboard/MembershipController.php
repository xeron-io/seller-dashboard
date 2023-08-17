<?php

namespace App\Http\Controllers\Dashboard;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class MembershipController extends Controller
{
    public function index()
    {
        return view('dashboard.membership', [
            'title' => 'Membership',
            'subtitle' => 'Upgrade membership anda untuk mendapatkan fitur yang lebih lengkap',
        ]);
    }
}
