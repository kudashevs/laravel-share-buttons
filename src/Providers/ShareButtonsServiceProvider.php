<?php

namespace Kudashevs\ShareButtons\Providers;

use Illuminate\Support\ServiceProvider;
use Kudashevs\ShareButtons\Share;

class ShareButtonsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang/', 'laravel-share');

        $this->publishes([
            __DIR__ . '/../../resources/lang/' => resource_path('lang/vendor/laravel-share'),
        ], 'translations');

        $this->publishes([
            __DIR__ . '/../../config/laravel-share.php' => config_path('laravel-share.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../public/js/share.js' => public_path('js/share.js'),
        ], 'assets');


    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind('share', function () {
            return new Share();
        });

        $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-share.php', 'laravel-share');
    }
}
