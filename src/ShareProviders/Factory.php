<?php

namespace Kudashevs\ShareButtons\ShareProviders;

use Kudashevs\ShareButtons\ShareProviders\Providers\ShareProvider;

final class Factory
{
    public const PROVIDERS = [
        'facebook' => Providers\Facebook::class,
        'twitter' => Providers\Twitter::class,
        'reddit' => Providers\Reddit::class,
        'telegram' => Providers\Telegram::class,
        'whatsapp' => Providers\WhatsApp::class,
        'linkedin' => Providers\LinkedIn::class,
        'pinterest' => Providers\Pinterest::class,
    ];

    /**
     * Factory constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return array
     */
    public static function create(): array
    {
        return self::generate();
    }

    /**
     * Populates an array of providers through interface.
     *
     * @return array
     */
    private static function generate(): array
    {
        $providers = [];

        foreach (self::PROVIDERS as $name => $class) {
            $providers[$name] = self::instantiateProvider($class);
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
