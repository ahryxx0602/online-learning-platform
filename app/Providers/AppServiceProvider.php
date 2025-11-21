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
        // Set locale mặc định là 'vi' để sử dụng translation tiếng Việt
        app()->setLocale('vi');
        // Set locale mặc định là 'en' để sử dụng translation tiếng Anh
        //app()->setLocale('en');
    }
}
