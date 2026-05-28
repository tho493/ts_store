<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Đăng ký các Livewire components
        if (class_exists(Livewire::class)) {
            Livewire::component('product-catalog', \App\Modules\Product\Livewire\ProductCatalog::class);
            Livewire::component('product-search', \App\Modules\Product\Livewire\ProductSearch::class);
            Livewire::component('cart-icon', \App\Modules\Cart\Livewire\CartIcon::class);
            Livewire::component('cart-drawer', \App\Modules\Cart\Livewire\CartDrawer::class);
            Livewire::component('checkout', \App\Modules\Order\Livewire\Checkout::class);
        }

        $modulesPath = app_path('Modules');

        // Tạo thư mục app/Modules nếu chưa tồn tại
        if (!File::exists($modulesPath)) {
            File::makeDirectory($modulesPath, 0755, true);
        }

        $modules = File::directories($modulesPath);

        foreach ($modules as $modulePath) {
            $moduleName = basename($modulePath);
            $lowerModuleName = strtolower($moduleName);

            try {
                // 1. Tải Helpers nếu có
                $helperFile = $modulePath . '/Helpers/helpers.php';
                if (File::exists($helperFile)) {
                    require_once $helperFile;
                }

                // 2. Tải Routes
                // Hỗ trợ routes.php trực tiếp hoặc routes/web.php
                $routeFile = $modulePath . '/routes.php';
                $routeWebFile = $modulePath . '/routes/web.php';

                if (File::exists($routeFile)) {
                    $this->loadRoutes($routeFile, $moduleName);
                } elseif (File::exists($routeWebFile)) {
                    $this->loadRoutes($routeWebFile, $moduleName);
                }

                // 3. Tải Views
                $viewsPath = $modulePath . '/Views';
                if (File::exists($viewsPath)) {
                    $this->loadViewsFrom($viewsPath, $lowerModuleName);
                }

                // 4. Tải Migrations
                $migrationsPath = $modulePath . '/Database/Migrations';
                if (File::exists($migrationsPath)) {
                    $this->loadMigrationsFrom($migrationsPath);
                }

            } catch (\Exception $e) {
                // Log lỗi hoặc ghi lại nếu module nào đó có lỗi khởi tạo
                throw $e;
            }
        }
    }

    /**
     * Load routes cho module cụ thể
     */
    private function loadRoutes(string $path, string $moduleName): void
    {
        Route::middleware('web')
            ->group($path);
    }
}
