<?php

namespace App\Http\Controllers\Dashboard;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
	public function profile()
	{
		return view('dashboard.profile', [
			'title' => 'My Profile',
			'subtitle' => 'Edit profile anda disini',
			'profile' => Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/myprofile')->json()['data'],
		]);
	}

	public function profile_save_basic(Request $request)
	{
		$oldData = Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/myprofile')->json()['data'];
		$request->validate([
			'firstname' => 'required|min:3|alpha',
			'lastname' => 'required|min:3|alpha',
			'email' => 'required|email',
			'phone' => 'required',
		]);

		$response = Http::withToken(session('token'))->put(env('BACKEND_URL').'/seller/myprofile', [
			'firstname' => $request->firstname,
			'lastname' => $request->lastname,
			'email' => $request->email,
			'phone' => $request->phone,
		])->json();

		if ($response['success'] == 'true') {
			return redirect()->route('dash.profile')->with('success', $response['message']);
		} else {
			return redirect()->route('dash.profile')->withInput()->with('api_errors', $response['errors'] ? $response['errors'] : $response['message']);
		}
	}

	public function profile_save_password(Request $request)
	{
		$oldData = Http::withToken(session('token'))->get(env('BACKEND_URL').'/seller/myprofile')->json()['data'];
		$request->validate([
			'old_password' => 'required',
			'new_password' => 'required|min:8',
			'confirm_new_password' => 'required|same:new_password',
		]);

		$response = Http::withToken(session('token'))->put(env('BACKEND_URL').'/seller/myprofile/password', [
			'oldPassword' => $request->old_password,
			'newPassword' => $request->new_password,
		])->json();

		if ($response['success'] == 'true') {
			return redirect()->route('dash.profile')->with('success', $response['message']);
		} else {
			return redirect()->route('dash.profile')->withInput()->with('api_errors', $response['errors'] ? $response['errors'] : $response['message']);
		}
	}
}
