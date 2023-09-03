<?php

use App\Http\Controllers\Dashboard\OverviewController;
use App\Http\Controllers\Dashboard\GameServerController;
use App\Http\Controllers\Dashboard\StoreController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\StockController;
use App\Http\Controllers\Dashboard\VoucherController;
use App\Http\Controllers\Dashboard\BankController;
use App\Http\Controllers\Dashboard\MembershipController;
use App\Http\Controllers\Dashboard\TransactionController;
use App\Http\Controllers\Dashboard\WithdrawController;
use App\Http\Controllers\Dashboard\DomainController;
use App\Http\Controllers\Dashboard\ReviewController;
use App\Http\Controllers\Dashboard\SetupController;
use Illuminate\Support\Facades\Route;

Route::middleware('jwt.auth')->group(function () {
	Route::get('/', [OverviewController::class, 'index'])->name('dash.overview');
	Route::get('/transactions/year', [OverviewController::class, 'getTransactions']);

	// Profile
	Route::get('/profile', [ProfileController::class, 'profile'])->name('dash.profile');
	Route::put('/profile/basic', [ProfileController::class, 'profile_save_basic'])->name('dash.profile.save.basic');
	Route::put('/profile/password', [ProfileController::class, 'profile_save_password'])->name('dash.profile.save.password');

	// Game Server
	Route::get('/gameserver', [GameServerController::class, 'index'])->name('dash.gameserver');
	Route::post('/gameserver', [GameServerController::class, 'create'])->name('dash.gameserver.create');
	Route::get('/gameserver/{id}', [GameServerController::class, 'detail'])->name('dash.gameserver.detail');
	Route::put('/gameserver/{id}', [GameServerController::class, 'edit'])->name('dash.gameserver.edit');
	Route::get('/gameserver/delete/{id}', [GameServerController::class, 'delete'])->name('dash.gameserver.delete');

	// Store
	Route::get('/store', [StoreController::class, 'index'])->name('dash.store');
	Route::post('/store', [StoreController::class, 'create'])->name('dash.store.create');	
	Route::get('/store/{id}', [StoreController::class, 'detail'])->name('dash.store.detail');
	Route::put('/store/{id}', [StoreController::class, 'edit'])->name('dash.store.edit');
	Route::get('/store/delete/{id}', [StoreController::class, 'delete'])->name('dash.store.delete');

	// Category
	Route::get('/category', [CategoryController::class, 'index'])->name('dash.category');
	Route::post('/category', [CategoryController::class, 'create'])->name('dash.category.create');
	Route::get('/category/{id}', [CategoryController::class, 'detail'])->name('dash.category.detail');
	Route::get('/category/filter/{id}', [CategoryController::class, 'filter'])->name('dash.category.filter');
	Route::put('/category/{id}', [CategoryController::class, 'edit'])->name('dash.category.edit');
	Route::get('/category/delete/{id}', [CategoryController::class, 'delete'])->name('dash.category.delete');

	// Product
	Route::get('/product', [ProductController::class, 'index'])->name('dash.product');
	Route::get('/product/{id}', [ProductController::class, 'detail'])->name('dash.product.detail');
	Route::post('/product', [ProductController::class, 'create'])->name('dash.product.create');
	Route::put('/product/{id}', [ProductController::class, 'edit'])->name('dash.product.edit');
	Route::get('/product/delete/{id}', [ProductController::class, 'delete'])->name('dash.product.delete');

	// Voucher
	Route::get('/voucher', [VoucherController::class, 'index'])->name('dash.voucher');
	Route::get('/voucher/{id}', [VoucherController::class, 'detail'])->name('dash.voucher.detail');
	Route::get('/voucher/usage/{id}', [VoucherController::class, 'usage'])->name('dash.voucher.usage');
	Route::post('/voucher', [VoucherController::class, 'create'])->name('dash.voucher.create');
	Route::put('/voucher/{id}', [VoucherController::class, 'edit'])->name('dash.voucher.edit');
	Route::get('/voucher/delete/{id}', [VoucherController::class, 'delete'])->name('dash.voucher.delete');

	// Review
	Route::get('/review', [ReviewController::class, 'index'])->name('dash.review');

	// Bank
	Route::get('/bank', [BankController::class, 'index'])->name('dash.bank');
	Route::post('/bank', [BankController::class, 'create'])->name('dash.bank.create');

	// Membership
	Route::get('/membership', [MembershipController::class, 'index'])->name('dash.membership');

	// Transaction
	Route::get('/transaction', [TransactionController::class, 'index'])->name('dash.transaction');
	Route::get('/transaction/{id}', [TransactionController::class, 'detail'])->name('dash.transaction.detail');
	Route::post('/transaction/cancel/{id}', [TransactionController::class, 'cancel'])->name('dash.transaction.cancel');
	Route::post('/transaction/refund/{id}', [TransactionController::class, 'refund'])->name('dash.transaction.refund');
	Route::post('/transaction/resend/{id}', [TransactionController::class, 'resend'])->name('dash.transaction.resend');

	// Withdraw
	Route::get('/withdraw', [WithdrawController::class, 'index'])->name('dash.withdraw');
	Route::post('/withdraw', [WithdrawController::class, 'create'])->name('dash.withdraw.create');

	// Custom Domain
	Route::get('/domain', [DomainController::class, 'index'])->name('dash.domain');
	Route::post('/domain', [DomainController::class, 'create'])->name('dash.domain.create');
	Route::delete('/domain/{id}', [DomainController::class, 'delete'])->name('dash.domain.delete');

	// Setup
	Route::get('/setup/1', [SetupController::class, 'step1'])->name('dash.setup1');
	Route::get('/setup/2', [SetupController::class, 'step2'])->name('dash.setup2');
	Route::get('/setup/3', [SetupController::class, 'step3'])->name('dash.setup3');
	Route::get('/setup/4', [SetupController::class, 'step4'])->name('dash.setup4');

	// Ping
	Route::get('/ping/{ip}/{port}', [GameServerController::class, 'ping'])->name('dash.ping');
});