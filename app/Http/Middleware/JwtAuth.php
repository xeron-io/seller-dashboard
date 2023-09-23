<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Models\Sellers;

class JwtAuth
{
   public function handle(Request $request, Closure $next)
   {
      if(!$request->session()->has('token')) return redirect()->route('login');
      if(is_null(AuthController::getJWT())) return redirect()->route('login');
      if(!AuthController::getJWT()) return redirect()->route('login');

      $seller = Sellers::where('id', AuthController::getJWT()->sub)->first();
      if($seller->status == 'suspended') {
         Session::flush();
         return redirect()->route('login')->withErrors(['email' => 'Akun anda telah di suspend.']);
      }
      return $next($request);
   }  
}