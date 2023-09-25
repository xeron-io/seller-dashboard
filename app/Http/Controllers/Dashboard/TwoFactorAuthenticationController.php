<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Sellers;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Env;
use App\Models\TwoFactorAuthentication;

class TwoFactorAuthenticationController extends Controller
{
    /**
     * Show 2FA Setting form
     */
    public function index() {
        $seller = Sellers::where('id', AuthController::getJWT()->sub)->first();
        $google2fa_url = "";
        $secret_key = "";

        if($seller->twoFactorAuthentication()->exists()){
            $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $google2fa_url = $google2fa->getQRCodeInline(
                Env::get('APP_NAME'),
                $seller->email,
                $seller->twoFactorAuthentication->google2fa_secret
            );
            $secret_key = $seller->twoFactorAuthentication->google2fa_secret;
        }

        $data = array(
            'seller' => $seller,
            'secret' => $secret_key,
            'google2fa_url' => $google2fa_url
        );

        return view('dashboard.twofactor', [
            'title' => '2FA',
            'subtitle' => 'Two Factor Authentication',
            'data' => $data
        ]);
    }

    /**
     * Generate 2FA secret key
     */
    public function generate2faSecret() {
        $seller = Sellers::where('id', AuthController::getJWT()->sub)->first();

        // Initialise the 2FA class
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        // Add the secret key to the registration data
        $two_factor_auth = TwoFactorAuthentication::firstOrNew(array('id_seller' => $seller->id));
        $two_factor_auth->id_seller = $seller->id;
        $two_factor_auth->google2fa_enable = 0;
        $two_factor_auth->google2fa_secret = $google2fa->generateSecretKey();
        $two_factor_auth->save();

        return redirect('/2fa')->with('success', "Secret key is generated, Please verify code to enable 2FA.");
    }

    /**
     * Enable 2FA
     */
    public function enable2fa(Request $request){
        $seller = Sellers::where('id', AuthController::getJWT()->sub)->first();
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        $secret = $request->input('secret');
        $valid = $google2fa->verifyKey($seller->twoFactorAuthentication->google2fa_secret, $secret);

        if($valid) {
            $seller->twoFactorAuthentication->google2fa_enable = 1;
            $seller->twoFactorAuthentication->ip_address = $request->ip();
            $seller->twoFactorAuthentication->user_agent = $request->header('User-Agent');
            $seller->twoFactorAuthentication->save();
            session()->put('2fa', true);
            return redirect('2fa')->with('success', "");
        }else {
            return redirect('2fa')->with('error',"Invalid verification Code, Please try again.");
        }
    }

    /**
     * Disable 2FA
     */
    public function disable2fa(Request $request){
        $request->validate([
            'current-password' => 'required',
        ]);

        $seller = Sellers::where('id', AuthController::getJWT()->sub)->first();
        if(!(Hash::check($request->get('current-password'),  $seller->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your password does not matches with your account password. Please try again.");
        }

        $seller->twoFactorAuthentication->google2fa_enable = 0;
        $seller->twoFactorAuthentication->save();
        return redirect('/2fa')->with('success', "You have successfully disabled 2FA.");
    }
}