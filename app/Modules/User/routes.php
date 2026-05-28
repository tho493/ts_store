<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\Http\Controllers\UserController;

// Các route cho khách hàng (Public & Guest)
Route::middleware(['guest'])->group(function() {
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('login.submit');
    
    Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UserController::class, 'register'])->name('register.submit');
});

// Các route yêu cầu khách hàng đăng nhập
Route::middleware(['auth'])->group(function() {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/my-orders', [UserController::class, 'myOrders'])->name('my_orders');
});
