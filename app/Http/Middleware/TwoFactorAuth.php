<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Sellers;
use App\Http\Controllers\AuthController;

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
        if($seller->twoFactorAuthentication()->exists()){
            if($seller->twoFactorAuthentication->google2fa_enable == 1){
                if(!session()->has('2fa') || session('2fa') != true){
                    return redirect()->route('2fa');
                }
            }
        }

        return $next($request);
    }
}
