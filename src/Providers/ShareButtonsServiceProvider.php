<?php

declare(strict_types=1);

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
        $this->publishes([
            __DIR__ . '/../../config/share-buttons.php' => config_path('share-buttons.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../resources/assets/js/share-buttons.js' => resource_path('assets/js/share-buttons.js'),
        ], 'assets');
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
     * @return array<string, bool|string>
     */
    protected function prepareConfig(): array
    {
        $config = [
            'templater' => config('share-buttons.templater'),
            'reportUnexpectedCalls' => config('share-buttons.reportUnexpectedCalls'),
        ];

        return array_filter($config);
    }
}
