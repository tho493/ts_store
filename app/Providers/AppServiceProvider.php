<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $proto = (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https' : 'http';
            config(['app.url' => $proto . '://' . $_SERVER['HTTP_X_FORWARDED_HOST']]);
        } elseif (isset($_SERVER['HTTP_HOST'])) {
            $proto = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
            config(['app.url' => $proto . '://' . $_SERVER['HTTP_HOST']]);
        }
    }
}
