<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Sellers;
use App\Http\Controllers\AuthController;

class CheckPremium
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $seller = Sellers::where('id', AuthController::getJWT()->id)->with('membership')->first();
        if($seller->membership->name != 'Premium') return redirect()->back();
        return $next($request);
    }
}
