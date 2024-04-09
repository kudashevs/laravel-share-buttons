<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Templaters;

class LaravelTemplater implements Templater
{
    /**
     * {@inheritDoc}
     *
     * @param string $template
     * @param array<string, string> $replacements
     * @return string
     */
    public function process(string $template, array $replacements): string
    {
        $result = trans($template, $replacements);

        return is_string($result) ? $result : '';
    }
}
