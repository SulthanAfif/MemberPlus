<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RedemptionController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

/*
| MemberPlus routes — copy ke routes/web.php project Laravel Anda.
| Middleware auth opsional: bungkus group dengan middleware(['auth']).
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Members
Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
Route::post('/members', [MemberController::class, 'store'])->name('members.store');
Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');
Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
Route::get('/api/members/search', [MemberController::class, 'search'])->name('members.search');

// Kasir / Sales
Route::get('/kasir', [SaleController::class, 'create'])->name('sales.create');
Route::post('/kasir', [SaleController::class, 'store'])->name('sales.store');
Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');

// Rewards (admin)
Route::get('/rewards', [RewardController::class, 'index'])->name('rewards.index');
Route::get('/rewards/create', [RewardController::class, 'create'])->name('rewards.create');
Route::post('/rewards', [RewardController::class, 'store'])->name('rewards.store');
Route::get('/rewards/{reward}/edit', [RewardController::class, 'edit'])->name('rewards.edit');
Route::put('/rewards/{reward}', [RewardController::class, 'update'])->name('rewards.update');
Route::delete('/rewards/{reward}', [RewardController::class, 'destroy'])->name('rewards.destroy');

// Redemption (tukar poin)
Route::get('/redeem', [RedemptionController::class, 'create'])->name('redemptions.create');
Route::post('/redeem', [RedemptionController::class, 'store'])->name('redemptions.store');
Route::get('/redemptions', [RedemptionController::class, 'index'])->name('redemptions.index');
