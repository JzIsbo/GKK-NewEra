<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // Force HTTPS URLs in production, on Vercel, or behind an SSL-terminating reverse proxy
        if (app()->environment('production') ||
            request()->header('x-forwarded-proto') === 'https' ||
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
            isset($_SERVER['VERCEL']) || isset($_ENV['VERCEL']) || env('VERCEL')) {
            URL::forceScheme('https');
        }
    }
}
