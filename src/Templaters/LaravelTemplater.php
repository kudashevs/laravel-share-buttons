<?php

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
