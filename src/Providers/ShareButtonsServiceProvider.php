<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Providers;

use Illuminate\Support\ServiceProvider;
use Kudashevs\ShareButtons\ShareButtons;

class ShareButtonsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/share-buttons.php' => config_path('share-buttons.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../resources/js/share-buttons.js' => resource_path('js/share-buttons.js'),
        ], ['js', 'vanilla']);

        $this->publishes([
            __DIR__ . '/../../resources/js/share-buttons.jquery.js' => resource_path('js/share-buttons.jquery.js'),
        ], ['js', 'jquery']);

        $this->publishes([
            __DIR__ . '/../../resources/css/share-buttons.css' => resource_path('css/share-buttons.css'),
        ], ['css']);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind(ShareButtons::class, function () {
            return new ShareButtons($this->prepareConfig());
        });
        $this->app->alias(ShareButtons::class, 'sharebuttons');

        $this->mergeConfigFrom(__DIR__ . '/../../config/share-buttons.php', 'share-buttons');
    }

    /**
     * @return array<string, string>
     */
    protected function prepareConfig(): array
    {
        $config = [
            'templater' => config('share-buttons.templater'),
        ];

        return array_filter($config);
    }
}
