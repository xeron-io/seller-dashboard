<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Models\Sellers;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserVerification;

class AuthController extends Controller
{
   public function Login()
   {
      return view('auth.login', [
			'title' => 'Login',
		]);
   }

   public function RequestLogin(LoginRequest $request)
   {
      $seller = Sellers::where('email', $request->email)->first();

      if($seller->isVerified == 0) {
         return redirect()->back()->withErrors(['email' => 'Email anda belum terverifikasi.']);
      }

      if(Hash::check($request->password, $seller->password)) {
         $payload = [
            'iss' => "xeron.io",
            'sub' => $seller->id,
            'iat' => time(), 
            'exp' => $request->remember ? time() + 604800 : time() + 3600,
         ];

         $jwt = JWT::encode($payload, env('JWT_KEY'), 'HS256');
         $request->session()->put('token', $jwt);

         return redirect()->route('dash.overview');
      } else {
         return redirect()->back()->withErrors(['password' => 'Password anda salah.']);
      }
   }

   public function Register()
   {
      return view('auth.register', [
			'title' => 'Register',
		]);
   }

   public function RequestRegister(RegisterRequest $request)
   {
      $seller = Sellers::create([
         'firstname' => $request->firstname,
         'lastname' => $request->lastname,
         'email' => $request->email,
         'password' => Hash::make($request->password),
         'phone' => $request->phone,
         'verification_token' => Str::uuid(),
      ]);

      Mail::to($seller->email)->send(new UserVerification($seller));
      return redirect()->route('register')->with('success', 'Akun anda berhasil dibuat. Silahkan cek email anda untuk verifikasi.');
   }

   public function ResendEmail()
   {
      return Inertia::render('Auth/ResendEmail', [
         'title' => 'Resend Email',
      ]);  
   }

   
   public function RequestResendEmail(Request $request)
   {
      if($request->session()->get('resend_email') > now()) {
         return Inertia::render('Auth/ResendEmail', [
            'title' => 'Resend Email',
            'msg' => 'Tunggu 1 menit untuk mengirimkan ulang email verifikasi',
         ]);
      }

      $request->validate([
         'email' => 'required|email',
      ]);

      $response = Http::post('http://127.0.0.1:3000/api/seller/auth/resend_email', [
         'email' => $request->email,
      ])->json();

      if($response['success'] == true) {
         $request->session()->put('resend_email', now()->addMinute());

         return Inertia::render('Auth/ResendEmail', [
            'title' => 'Resend Email',
            'success' => 'Email verifikasi berhasil dikirim ulang',
         ]);
      } 
      else {
         return Inertia::render('Auth/ResendEmail', [
            'title' => 'Resend Email',
            'msg' => $response['message'],
         ]);
      }
   }

   public function ForgetPassword()
   {
      return Inertia::render('Auth/ForgetPassword', [
         'title' => 'Forget Password',
      ]);  
   }

   public function RequestForgetPassword(Request $request)
   {
      if($request->session()->get('forget_password') > now()) {
         return Inertia::render('Auth/ForgetPassword', [
            'title' => 'Forget Password',
            'msg' => 'Tunggu 1 menit untuk mengirimkan ulang email forget password',
         ]);
      }

      $request->validate([
         'email' => 'required|email',
      ]);

      $response = Http::post('http://127.0.0.1:3000/api/seller/auth/forget_password', [
         'email' => $request->email,
      ])->json();

      if($response['success'] == true) {
         $request->session()->put('forget_password', now()->addMinute());

         return Inertia::render('Auth/ForgetPassword', [
            'title' => 'Forget Password',
            'success' => 'Silahkan cek email anda untuk mereset password',
         ]);
      } 
      else {
         return Inertia::render('Auth/ForgetPassword', [
            'title' => 'Forget Password',
            'msg' => $response['message'],
         ]);
      }
   }

   public function ResetPassword($token)
   {
      return Inertia::render('Auth/ResetPassword', [
         'title' => 'Reset Password',
         'token' => $token,
      ]);  
   }

   public function RequestResetPassword(Request $request)
   {
      $request->validate([
         'token' => 'required',
         'password' => 'required|string|min:8|max:255',
         'confirm_password' => 'required|string|min:8|max:255|same:password',
      ]);

      $response = Http::put('http://127.0.0.1:3000/api/seller/auth/reset_password', [
         'forgetPasswordToken' => $request->token,
         'password' => $request->password,
      ])->json();

      if($response['success'] == true) {
         return Inertia::render('Auth/ResetPassword', [
            'title' => 'Reset Password',
            'success' => true,
         ]);
      } 
      else {
         return Inertia::render('Auth/ResetPassword', [
            'title' => 'Reset Password',
            'msg' => $response['message'],
         ]);
      }
   }

   public function logout(Request $request)
   {
      $request->session()->forget('token');
      $request->session()->flush();
      return redirect()->route('login');
   }

   public static function getJWT()
   {
      try {
         if(!session()->has('token')) return redirect()->route('login');
         $decoded = JWT::decode(session('token'), new Key(env('JWT_KEY'), 'HS256'));

         // check if token is expired
         if($decoded->exp < time()) {
            return redirect()->route('login');
         }

         return $decoded;
      } catch (ExpiredException) {
         return redirect()->route('login');
      }
   }

   public static function generateJWT($payload)
   {
      $jwt = JWT::encode($payload, env('JWT_KEY'), 'HS256');
      return $jwt;
   }

   public static function verification($token)
   {
      $seller = Sellers::where('verification_token', $token)->first();
   
      if($seller) {
         $seller->update([
            'verification_token' => '',
            'isVerified' => '1',
         ]);
         return redirect()->route('login')->with('success', 'Akun anda berhasil diverifikasi');
      }
      else {
         return redirect()->route('login')->with('error', 'Token verifikasi tidak valid');
      }
   }
}