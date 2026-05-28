<?php

use Illuminate\Support\Facades\Route;

// Trang checkout được bảo vệ bởi middleware kiểm tra bật/tắt giỏ hàng
Route::middleware(['check_cart'])->group(function() {
    Route::get('/checkout', \App\Modules\Order\Livewire\Checkout::class)->name('checkout');
});
