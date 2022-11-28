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

    public static function createFromOptions(array $options): Templater
    {
        $class = $options['templater'] ?? self::getDefaultClass();

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
    private static function getDefaultClass(): string
    {
        return SimpleColonTemplater::class;
    }
}
