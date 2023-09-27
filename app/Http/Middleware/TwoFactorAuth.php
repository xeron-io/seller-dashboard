<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Sellers;
use App\Http\Controllers\AuthController;
use App\Models\TwoFactorAuthentication;

class TwoFactorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $seller = Sellers::where('id', AuthController::getJWT()->sub)->first();
        dd($request->ip());
        if($seller->twoFactorAuthentication()->exists()){
            if($seller->twoFactorAuthentication->google2fa_enable == 1){
                $two_factor_auth = TwoFactorAuthentication::where('id_seller', $seller->id)->first();
                if(!session()->has('2fa') || session('2fa') != true) {
                    if($two_factor_auth->ip_address == $request->ip() && $two_factor_auth->user_agent == $request->userAgent()) {
                        return $next($request);
                    }
                    else {
                        return redirect()->route('2fa');
                    }
                }
            }
        }

        return $next($request);
    }
}
