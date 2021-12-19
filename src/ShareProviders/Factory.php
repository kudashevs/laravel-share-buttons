<?php

namespace Kudashevs\ShareButtons\ShareProviders;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

final class Factory
{
    /**
     * @todo don't forget to update these providers
     */
    public const PROVIDERS = [
        'copylink' => Providers\CopyLink::class,
        'facebook' => Providers\Facebook::class,
        'linkedin' => Providers\LinkedIn::class,
        'pinterest' => Providers\Pinterest::class,
        'reddit' => Providers\Reddit::class,
        'telegram' => Providers\Telegram::class,
        'twitter' => Providers\Twitter::class,
        'vkontakte' => Providers\Vkontakte::class,
        'whatsapp' => Providers\WhatsApp::class,
    ];

    /**
     * Factory constructor.
     */
    private function __construct()
    {
    }

    /**
     * Populates an array of providers through interface.
     *
     * @return array
     */
    public static function create(): array
    {
        $providers = [];

        foreach (Factory::PROVIDERS as $name => $class) {
            $providers[$name] = Factory::instantiateProvider($class);
        }

        return $providers;
    }

   /**
     * @param $provider
     * @return ShareProvider
     */
    private static function instantiateProvider(string $provider): ShareProvider
    {
        return new $provider();
    }
}
