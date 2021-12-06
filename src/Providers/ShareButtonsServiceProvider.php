<?php

namespace Kudashevs\ShareButtons\Providers;

use Illuminate\Support\ServiceProvider;
use Kudashevs\ShareButtons\ShareButtons;

class ShareButtonsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang/', 'share-buttons');

        $this->publishes([
            __DIR__ . '/../../resources/lang/' => resource_path('lang/vendor/share-buttons'),
        ], 'translations');

        $this->publishes([
            __DIR__ . '/../../config/share-buttons.php' => config_path('share-buttons.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../public/js/share-buttons.js' => public_path('js/share-buttons.js'),
        ], 'assets');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind('share', function () {
            return new ShareButtons();
        });

        $this->mergeConfigFrom(__DIR__ . '/../../config/share-buttons.php', 'share-buttons');
    }
}
