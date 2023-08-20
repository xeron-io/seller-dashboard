<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(function () {
    Route::get('/login', [AuthController::class, 'Login'])->name('login');
    Route::post('/login', [AuthController::class, 'RequestLogin'])->name('request_login');

    Route::get('/register', [AuthController::class, 'Register'])->name('register');
    Route::post('/register', [AuthController::class, 'RequestRegister'])->name('request_register');

    Route::get('/forget_password', [AuthController::class, 'ForgetPassword'])->name('forget_password');
    Route::post('/forget_password', [AuthController::class, 'RequestForgetPassword'])->name('request_forget_password');

    Route::get('/reset_password/{token}', [AuthController::class, 'ResetPassword'])->name('reset_password');
    Route::post('/reset_password/{token}', [AuthController::class, 'RequestResetPassword'])->name('request_reset_password');
    
    Route::get('/logout', [AuthController::class, 'Logout'])->name('logout');

    Route::get('/verify/{token}', [AuthController::class, 'verification'])->name('verify');
});