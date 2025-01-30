<?php

namespace App\Providers;

use App\Service\WablasService;
use Illuminate\Support\ServiceProvider;

class WablasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WablasService::class, function ($app) {
            return new WablasService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
