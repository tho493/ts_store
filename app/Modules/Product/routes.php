<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Product\Livewire\ProductCatalog;
use App\Modules\Product\Http\Controllers\ProductController;

// Trang chủ hiển thị Catalog sản phẩm pin
Route::get('/', ProductCatalog::class)->name('home');

// Trang chi tiết sản phẩm pin chuẩn SEO
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
