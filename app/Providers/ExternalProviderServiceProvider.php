<?php

namespace App\Providers;

use App\ExternalServices\SwProducts\SwProducts;
use App\ExternalServices\SmsActivate\SmsActivate;
use Illuminate\Support\ServiceProvider;


class ExternalProviderServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge user config with default config
        // $this->mergeConfigFrom(__DIR__ . '/../config/external_provider.php', 'external_provider');

        // Bind Tap to the app container
        $this->app->bind('smsactivate', function () {
            return new SmsActivate();
        });
        $this->app->bind('SwProducts', function () {
            return new SwProducts();
        });
    }

    public function provides()
    {
        return [
            'smsactivate',
            'SwProducts'
        ];
    }
    // public function boot()
    // {
    //     // Views
    //     $this->loadViewsFrom(__DIR__ . '/../resources/views', 'external_provider');

    //     if ($this->app->runningInConsole()) {
    //         // Migrations
    //         $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

    //         // Publish Configs
    //         $this->publishes([
    //             __DIR__ . '/../config/external_provider.php' => config_path('external_provider.php'),
    //         ], 'config');
    //     }


    // }
}
