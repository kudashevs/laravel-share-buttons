<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Templaters;

class LaravelTemplater implements Templater
{
    /**
     * @inheritDoc
     */
    public function process(string $template, array $replacements): string
    {
        return trans($template, $replacements);
    }
}
