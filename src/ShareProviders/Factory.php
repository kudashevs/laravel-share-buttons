<?php

namespace Kudashevs\ShareButtons\ShareProviders;

use Kudashevs\ShareButtons\Exceptions\InvalidShareProviderNameException;
use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

final class Factory
{
    /**
     * @todo don't forget to update these providers
     */
    protected const PROVIDERS = [
        'copylink' => Providers\CopyLink::class,
        'evernote' => Providers\Evernote::class,
        'facebook' => Providers\Facebook::class,
        'linkedin' => Providers\LinkedIn::class,
        'pinterest' => Providers\Pinterest::class,
        'pocket' => Providers\Pocket::class,
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
     * @return string[]
     */
    public static function getProviders(): array
    {
        return self::PROVIDERS;
    }

    /**
     * Populates an array of providers through interface.
     *
     * @return array
     */
    public static function create(): array
    {
        $providers = [];

        foreach (self::PROVIDERS as $name => $class) {
            $providers[$name] = self::instantiateProvider($class, $name);
        }

        return $providers;
    }

    /**
     * @param string $name
     * @return \Kudashevs\ShareButtons\ShareProviders\ShareProvider
     */
    public static function createInstance(string $name): ShareProvider
    {
        if (!array_key_exists($name, self::PROVIDERS)) {
            throw new InvalidShareProviderNameException('The ' . $name . ' is not a valid name for a share provider.');
        }

        return self::instantiateProvider(self::PROVIDERS[$name], $name);
    }

    /**
     * @param string $class
     * @param string $name
     * @return ShareProvider
     */
    private static function instantiateProvider(string $class, string $name): ShareProvider
    {
        return new $class($name);
    }
}
