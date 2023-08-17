<?php

use App\Http\Controllers\Dashboard\OverviewController;
use App\Http\Controllers\Dashboard\StoreController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\StockController;
use App\Http\Controllers\Dashboard\VoucherController;
use App\Http\Controllers\Dashboard\BankController;
use App\Http\Controllers\Dashboard\MembershipController;
use App\Http\Controllers\Dashboard\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('jwt.auth')->group(function () {
	Route::get('/', [OverviewController::class, 'index'])->name('dash.overview');

	// Profile
	Route::get('/profile', [ProfileController::class, 'profile'])->name('dash.profile');
	Route::put('/profile/basic', [ProfileController::class, 'profile_save_basic'])->name('dash.profile.save.basic');
	Route::put('/profile/password', [ProfileController::class, 'profile_save_password'])->name('dash.profile.save.password');

	// Store
	Route::get('/store', [StoreController::class, 'index'])->name('dash.store');
	Route::get('/store/edit/{id}', [StoreController::class, 'edit'])->name('dash.store.edit');
	Route::get('/store/theme/{id}', [StoreController::class, 'theme'])->name('dash.store.theme');
	Route::post('/store', [StoreController::class, 'create'])->name('dash.store.create');	
	Route::put('/store/{id}', [StoreController::class, 'edit_store'])->name('dash.store.edit_save');
	Route::get('/store/delete/{id}', [StoreController::class, 'delete'])->name('dash.store.delete');
	Route::post('/store/theme/{id}', [StoreController::class, 'theme_save'])->name('dash.store.theme_save');

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

	// Stock
	Route::get('/stock', [StockController::class, 'index'])->name('dash.stock');
	Route::get('/stock/{id}', [StockController::class, 'detail'])->name('dash.stock.detail');
	Route::post('/stock', [StockController::class, 'create'])->name('dash.stock.create');
	Route::put('/stock/{id}', [StockController::class, 'edit'])->name('dash.stock.edit');
	Route::get('/stock/delete/{id}', [StockController::class, 'delete'])->name('dash.stock.delete');

	// Voucher
	Route::get('/voucher', [VoucherController::class, 'index'])->name('dash.voucher');
	Route::get('/voucher/{id}', [VoucherController::class, 'detail'])->name('dash.voucher.detail');
	Route::post('/voucher', [VoucherController::class, 'create'])->name('dash.voucher.create');
	Route::put('/voucher/{id}', [VoucherController::class, 'edit'])->name('dash.voucher.edit');
	Route::get('/voucher/delete/{id}', [VoucherController::class, 'delete'])->name('dash.voucher.delete');

	// Bank
	Route::get('/bank', [BankController::class, 'index'])->name('dash.bank');
	Route::post('/bank', [BankController::class, 'create'])->name('dash.bank.create');

	// Membership
	Route::get('/membership', [MembershipController::class, 'index'])->name('dash.membership');

	// Transaction
	Route::get('/transaction', [TransactionController::class, 'index'])->name('dash.transaction');
	Route::get('/transaction/cancel/{id}', [TransactionController::class, 'cancel'])->name('dash.transaction.cancel');
});