<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share current locale with all views
        View::share('currentLocale', App::getLocale());

        // Set RTL for Arabic
        View::share('isRTL', App::getLocale() === 'ar');
    }
}
