<?php

namespace Kudashevs\ShareButtons\ShareProviders;

use Kudashevs\ShareButtons\ShareProviders\Providers\ShareProvider;

final class Factory
{
    /**
     * @var array
     */
    public static $providers = [
        'facebook' => Providers\Facebook::class,
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

        foreach (self::$providers as $name => $class) {
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
