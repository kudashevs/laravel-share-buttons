<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Factories;

use Kudashevs\ShareButtons\Exceptions\InvalidFactoryArgumentException;
use Kudashevs\ShareButtons\ShareProviders\Providers;
use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

final class ShareProviderFactory
{
    /**
     * @todo don't forget to update these providers
     */
    private const PROVIDERS = [
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
        'xing' => Providers\Xing::class,
    ];

    private function __construct()
    {
    }

    public static function isValidProvider(string $name, string $class): bool
    {
        return self::isValidProviderName($name) && self::PROVIDERS[$name] === $class;
    }

    public static function isValidProviderName(string $name): bool
    {
        return array_key_exists($name, self::PROVIDERS);
    }

    /**
     * @param string $name
     * @return ShareProvider
     *
     * @throws InvalidFactoryArgumentException
     */
    public static function createFromName(string $name): ShareProvider
    {
        $class = self::resolveClass($name);

        return $class::create();
    }

    public static function createFromMethodCall(
        string $name,
        string $page,
        string $title,
        array $arguments
    ): ShareProvider {
        $class = self::resolveClass($name);
        $instance = new $class();
        $instance->buildUrl($page, $title, $arguments);

        return $instance;
    }

    private static function resolveClass(string $name): string
    {
        if (!self::isValidProviderName($name)) {
            throw new InvalidFactoryArgumentException(
                sprintf('The %s is not a valid name for a share provider.', $name)
            );
        }

        return self::PROVIDERS[$name];
    }
}
