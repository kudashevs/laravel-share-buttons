<?php

namespace Kudashevs\ShareButtons\ShareProviders;

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
        return self::$providers;
    }
}
