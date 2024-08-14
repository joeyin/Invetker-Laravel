<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::prefix('/api/user')->group(function () {
    Route::post('/login', [UserController::class, 'login'])->name('user.login');
    Route::post('/register', [UserController::class, 'register'])->name('user.register');
});

Route::get('/user/login', function () {
    return redirect()->route('home');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.home');
        Route::get('/transactions', [DashboardController::class, 'transactions'])->name('dashboard.transactions');
        Route::get('/about', [DashboardController::class, 'about'])->name('dashboard.about');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    });

    Route::prefix('/api')->group(function () {
        Route::prefix('/transaction')->group(function () {
            Route::post('/', [TransactionController::class, 'create']);
            Route::get('/{id}', [TransactionController::class, 'index'])->where('id', '[0-9]+');
            Route::put('/{id}', [TransactionController::class, 'update'])->where('id', '[0-9]+');
            Route::delete('/{id}', [TransactionController::class, 'delete'])->where('id', '[0-9]+');
        });
        Route::prefix('/about')->group(function () {
            Route::put('/', [AboutController::class, 'update']);
        });
        Route::put('/user', [UserController::class, 'update']);
    });

    Route::get('/user/logout', [UserController::class, 'logout'])->middleware('auth')->name('user.logout');
});