<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
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
        //
        Schema::defaultStringLength(191);
        // Configuración para fechas en español
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_ALL, 'es_CL', 'es', 'ES', 'es_CLtf8');
    }
}
