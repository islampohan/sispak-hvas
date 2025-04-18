<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register DomPDF wrapper
        $this->app->bind('dompdf.wrapper', function() {
            return new \Barryvdh\DomPDF\PDF;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gunakan default string length pada schema untuk MySQL versi lama
        Schema::defaultStringLength(191);
    }
}
