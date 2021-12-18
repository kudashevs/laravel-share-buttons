<?php

namespace Kudashevs\ShareButtons\Providers;

use Illuminate\Support\ServiceProvider;
use Kudashevs\ShareButtons\Formatters\Formatter;
use Kudashevs\ShareButtons\Formatters\TranslateFormatter;
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

        $this->mergeConfigFrom(__DIR__ . '/../../config/share-buttons.php', 'share-buttons');
    }

    /**
     * @return Formatter
     */
    protected function getDefaultFormatter(): Formatter
    {
        return new TranslateFormatter();
    }
}
