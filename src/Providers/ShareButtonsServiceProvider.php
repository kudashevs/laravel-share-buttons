<?php

namespace Kudashevs\ShareButtons\Providers;

use Illuminate\Support\ServiceProvider;
use Kudashevs\ShareButtons\Formatters\Formatter;
use Kudashevs\ShareButtons\Formatters\TemplateFormatter;
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
            $formatter = $this->getDefaultFormatter();
            $options = [
                'reactOnErrors' => config('share-buttons.reactOnErrors'),
                'throwException' => config('share-buttons.throwException'),
            ];

            return new ShareButtons($formatter, $options);
        });
        $this->app->alias(ShareButtons::class, 'share');

        $this->mergeConfigFrom(__DIR__ . '/../../config/share-buttons.php', 'share-buttons');
    }

    /**
     * @return Formatter
     */
    protected function getDefaultFormatter(): Formatter
    {
        return new TemplateFormatter();
    }
}
