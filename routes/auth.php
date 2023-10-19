<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(function () {
    Route::get('/login', [AuthController::class, 'Login'])->name('login');
    Route::post('/login', [AuthController::class, 'RequestLogin'])->name('request_login');

    Route::get('/register', [AuthController::class, 'Register'])->name('register');
    Route::post('/register', [AuthController::class, 'RequestRegister'])->name('request_register');

    Route::get('/register/verify', [AuthController::class, 'ResendVerify'])->name('resend_verify');
    Route::post('/register/verify', [AuthController::class, 'RequestVerify'])->name('request_verify');

    Route::get('/2fa', [AuthController::class, 'twoFactor'])->name('2fa');
    Route::post('/2fa', [AuthController::class, 'twoFactorVerify'])->name('2fa_verify');

    Route::get('/forget_password', [AuthController::class, 'ForgetPassword'])->name('forget_password');
    Route::post('/forget_password', [AuthController::class, 'RequestForgetPassword'])->name('request_forget_password');

    Route::get('/reset_password/{token}', [AuthController::class, 'ResetPassword'])->name('reset_password');
    Route::post('/reset_password/{token}', [AuthController::class, 'RequestResetPassword'])->name('request_reset_password');
    
    Route::get('/logout', [AuthController::class, 'Logout'])->name('logout');

    Route::get('/verify/{token}', [AuthController::class, 'verification'])->name('verify');
});