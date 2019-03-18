<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::directive('loadLocalCSS', function ($filePath) {
            $path = public_path($filePath);
            if (file_exists($path)) {
                return "<link rel='stylesheet' href='". $filePath . "?date=" . \File::lastModified($path)."'>";
            }
            return '';
        });
        Blade::directive('loadLocalJS', function ($filePath) {
            $path = public_path($filePath);
            if (file_exists($path)) {
                return "<script src='" . $filePath . "?date=" .\File::lastModified($path) ."'></script>";
            }
            return '';
        });

        Blade::directive('loadeExternalJS', function ($filePath) {
            return "<script src='" . $filePath . "'></script>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__.'./../helpers.php';
    }
}
