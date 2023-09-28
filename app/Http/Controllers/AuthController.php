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
use App\Mail\ResetPassword;
use App\Models\Store;
use App\Models\TwoFactorAuthentication;

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

      if($seller->status == 'suspended') {
         return redirect()->back()->withErrors(['email' => 'Akun anda telah di suspend.']);
      }

      if(Hash::check($request->password, $seller->password)) {
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

         $jwt = JWT::encode($payload, env('JWT_KEY'), 'HS256');
         $request->session()->put('token', $jwt);

         $store = Store::where('id_seller', $seller->id)->first();
         if(!$store) {
            return redirect()->route('dash.setup1');
         }

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
         'firstname' => strtolower($request->firstname),
         'lastname' => strtolower($request->lastname),
         'email' => strtolower($request->email),
         'password' => Hash::make($request->password),
         'phone' => $request->phone,
         'verification_token' => Str::uuid(),
      ]);

      Mail::to($seller->email)->send(new UserVerification($seller));
      return redirect()->route('register')->with('success', 'Akun anda berhasil dibuat. Silahkan cek email anda untuk verifikasi.');
   }

   public function ForgetPassword()
   {
      return view('auth.forget', [
         'title' => 'Forget Password',
      ]);
   }

   public function RequestForgetPassword(Request $request)
   {
      if($request->session()->get('forget_password') > now()) {
         return back()->withErrors(['email' => 'Tunggu 1 menit untuk mengirimkan ulang email reset password']);
      }

      $messages = [
         'email.required' => 'Email harus diisi',
         'email.email' => 'Email tidak valid',
         'email.exists' => 'Email anda tidak terdaftar',
      ];

      $request->validate([
         'email' => 'required|email|exists:sellers,email',
      ], $messages);

      $seller = Sellers::where('email', $request->email)->first();
      if($seller) {
         $seller->forget_password_token = Str::uuid();
         $seller->save();

         Mail::to($seller->email)->send(new ResetPassword($seller));
         $request->session()->put('forget_password', now()->addMinute());

         return back()->with('success', 'Email reset password berhasil dikirim');
      }
      
      return back()->withErrors(['email' => 'Email anda tidak terdaftar']);
   }

   public function ResetPassword($token)
   {
      return view('auth.reset', [
         'title' => 'Reset Password',
         'token' => $token,
      ]);
   }

   public function RequestResetPassword(Request $request, $token)
   {
      $request->validate([
         'password' => 'required|string|min:8|max:255',
         'confirm_password' => 'required|string|min:8|max:255|same:password',
      ]);

      $seller = Sellers::where('forget_password_token', $token)->first();
      if($seller) {
         $seller->password = Hash::make($request->password);
         $seller->forget_password_token = '';
         $seller->save();

         return redirect()->route('login')->with('success', 'Password anda berhasil di reset');
      }

      return back()->withErrors(['password' => 'Token anda tidak valid']);
   }

   public function logout(Request $request)
   {
      $request->session()->forget('token');
      $request->session()->flush();
      TwoFactorAuthentication::where('id_seller', self::getJWT()->sub)->update([
         'ip_address' => '',
         'user_agent' => '',
      ]);
      return redirect()->route('login');
   }

   public static function getJWT()
   {
      try {
         if(!session()->has('token')) return redirect()->route('login');
         return JWT::decode(session('token'), new Key(env('JWT_KEY'), 'HS256'));
      } catch (ExpiredException) {
         return false;
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

   public static function twoFactor()
   {
      $seller = Sellers::where('id', self::getJWT()->sub)->first();
      return view('auth.twofactor', [
         'title' => '2FA',
         'seller' => $seller,
      ]);
   }

   public static function twoFactorVerify(Request $request)
   {
      $seller = Sellers::where('id', self::getJWT()->sub)->first();
      $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

      $pin = $request->input('pin');
      $valid = $google2fa->verifyKey($seller->twoFactorAuthentication->google2fa_secret, $pin);

      if($valid) {
         session()->put('2fa', true);
         TwoFactorAuthentication::where('id_seller', $seller->id)->update([
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
         ]);
         
         return redirect()->route('dash.overview');
      }
      else {
         return redirect()->back()->withErrors(['pin' => 'Kode verifikasi 2fa tidak valid']);
      }
   }
}