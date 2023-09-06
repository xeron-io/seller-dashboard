<?php

namespace App\Http\Controllers\Dashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Sellers;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
	public function profile()
	{
		return view('dashboard.profile', [
			'title' => 'My Profile',
			'subtitle' => 'Edit profile anda disini',
			'profile' => Sellers::where('id', AuthController::getJWT()->sub)->first(),
		]);
	}

	public function profile_save_basic(Request $request)
	{
		$request->validate([
			'firstname' => 'required|min:3|string',
			'lastname' => 'required|min:3|string',
			'email' => 'required|email|unique:sellers,email,'.AuthController::getJWT()->sub.',id',
			'phone' => 'required|numeric|unique:sellers,phone,'.AuthController::getJWT()->sub.',id',
		]);

		$seller = Sellers::where('id', AuthController::getJWT()->sub)->first();
		$seller->update([
			'firstname' => $request->firstname,
			'lastname' => $request->lastname,
			'email' => $request->email,
			'phone' => $request->phone,
		]);

		// generate new token
		$payload = [
      'iss' => "xeron.io",
      'sub' => $seller->id,
      'iat' => time(), 
      'exp' => $request->remember ? time() + 604800 : time() + 3600,
      'initial' => strtoupper($seller->firstname[0].$seller->lastname[0]),
      'name' => $seller->firstname.' '.$seller->lastname,
      'email' => $seller->email,
      'membership' => $seller->membership->name,
    ];

		$token = AuthController::generateJWT($payload);
		$request->session()->put('token', $token);

		return redirect()->route('dash.profile')->with('success', 'Profile anda berhasil di update');
	}

	public function profile_save_password(Request $request)
	{
		$seller = Sellers::where('id', AuthController::getJWT()->sub)->first();
		$request->validate([
			'old_password' => 'required|min:8',
			'new_password' => 'required|min:8',
			'confirm_new_password' => 'required|min:8|same:new_password',
		]);

		// check if old password is match with password in database
		if (!Hash::check($request->old_password, $seller->password)) {
			return redirect()->route('dash.profile')->with('api_errors', 'Password lama anda tidak sesuai');
		}

		// check if new password is match with old password
		if (Hash::check($request->new_password, $seller->password)) {
			return redirect()->route('dash.profile')->with('api_errors', 'Password baru anda sama dengan password lama');
		}

		Sellers::where('id', AuthController::getJWT()->sub)->update([
			'password' => Hash::make($request->new_password),
		]);

		return redirect()->route('dash.profile')->with('success', 'Password anda berhasil di update');
	}
}
