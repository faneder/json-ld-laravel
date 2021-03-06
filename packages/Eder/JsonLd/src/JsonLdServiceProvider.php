<?php

namespace Eder\JsonLd;

use Illuminate\Support\ServiceProvider;

class JsonLdServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';

        $this->publishes([
            __DIR__ . '/config' => config_path('jsonLd'),
        ]);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Eder\JsonLd\JsonLdController');

        $this->mergeConfigFrom(
            __DIR__ . '/config/companyInfo.php', 'companyInfo'
        );
    }
}


