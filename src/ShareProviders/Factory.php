<?php

namespace Kudashevs\ShareButtons\ShareProviders;

use Kudashevs\ShareButtons\Exceptions\InvalidShareProviderNameException;

final class Factory
{
    /**
     * @todo don't forget to update these providers
     */
    protected const PROVIDERS = [
        'copylink' => Providers\CopyLink::class,
        'evernote' => Providers\Evernote::class,
        'facebook' => Providers\Facebook::class,
        'hackernews' => Providers\HackerNews::class,
        'linkedin' => Providers\LinkedIn::class,
        'mailto' => Providers\MailTo::class,
        'pinterest' => Providers\Pinterest::class,
        'pocket' => Providers\Pocket::class,
        'reddit' => Providers\Reddit::class,
        'skype' => Providers\Skype::class,
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

        foreach (array_keys(self::PROVIDERS) as $name) {
            $providers[$name] = self::createInstance($name);
        }

        return $providers;
    }

    /**
     * @param string $name
     * @return ShareProvider
     */
    public static function createInstance(string $name): ShareProvider
    {
        $class = self::resolveClass($name);

        return new $class($name);
    }

    /**
     * @param string $name
     * @return string
     */
    private static function resolveClass(string $name): string
    {
        if (!array_key_exists($name, self::PROVIDERS)) {
            throw new InvalidShareProviderNameException(
                sprintf('The %s is not a valid name for a share provider.', $name)
            );
        }

        return self::PROVIDERS[$name];
    }
}
