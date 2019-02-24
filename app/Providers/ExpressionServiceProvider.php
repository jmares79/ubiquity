<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ExpressionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('App\Services\ExpressionService', ExpressionService::class);
    }
}
