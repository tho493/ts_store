<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Core\Http\Controllers\AdminController;
use App\Modules\Product\Http\Controllers\InventoryController;

// Các route quản trị Admin
Route::prefix('admin')->name('admin.')->group(function() {
    
    // Đăng nhập Admin (Public)
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.submit');
    
    // Các route yêu cầu đăng nhập quản trị
    Route::middleware(['admin_auth'])->group(function() {
        
        // Đăng xuất
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        
        // Dashboard & Cấu hình
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        
        // CRUD Sản phẩm
        Route::get('/products', [AdminController::class, 'products'])->name('products');
        Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
        Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
        Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
        Route::post('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
        Route::post('/products/{id}/quick-update', [AdminController::class, 'quickUpdateProduct'])->name('products.quick_update');
        Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('products.delete');
        
        // CRUD Danh mục
        Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('categories.delete');
        
        // Quản lý tài khoản khách hàng
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::post('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::post('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle_status');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
        
        // Quản lý đơn hàng (Chỉ truy cập khi bật giỏ hàng)
        Route::middleware(['check_cart'])->group(function() {
            Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
            Route::post('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update_status');
        });

        // Quản lý kho
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
        Route::get('/inventory/product/{id}', [InventoryController::class, 'byProduct'])->name('inventory.product');
        Route::get('/inventory/adjust/{id}', [InventoryController::class, 'createAdjustment'])->name('inventory.adjust');
        Route::post('/inventory/adjust/{id}', [InventoryController::class, 'storeAdjustment'])->name('inventory.adjust.store');
    });
});
