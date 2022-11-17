<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Templaters;

class LaravelTemplater implements Templater
{
    /**
     * @inheritDoc
     */
    public function render(string $template, array $replacements): string
    {
        return trans($template, $replacements);
    }
}
