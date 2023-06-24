<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Factories;

use Kudashevs\ShareButtons\Exceptions\InvalidTemplaterFactoryArgument;
use Kudashevs\ShareButtons\Templaters\SimpleColonTemplater;
use Kudashevs\ShareButtons\Templaters\Templater;

final class TemplaterFactory
{
    private function __construct()
    {
    }

    /**
     * Retrieve and create an instance of Templater implementation from options.
     * If a Templater class is not provided, the default Templater is created.
     *
     * @param array<string, string> $options
     * @return Templater
     */
    public static function createFromOptions(array $options): Templater
    {
        /** @var class-string<Templater> $class */
        $class = $options['templater'] ?? self::getDefaultTemplaterClass();

        if (!self::isValidTemplater($class)) {
            throw new InvalidTemplaterFactoryArgument(
                sprintf('The %s is not a valid class name for a templater.', $class)
            );
        }

        return new $class();
    }

    private static function isValidTemplater(string $class): bool
    {
        return class_exists($class) && is_a($class, Templater::class, true);
    }

    /**
     * @return class-string<Templater>
     */
    private static function getDefaultTemplaterClass(): string
    {
        return SimpleColonTemplater::class;
    }
}
