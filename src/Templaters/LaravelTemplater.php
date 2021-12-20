<?php

namespace Kudashevs\ShareButtons\Templaters;

class LaravelTemplater implements Templater
{
    /**
     * @inheritDoc
     */
    public function process(string $line, array $replacements): string
    {
       return trans($line, $replacements);
    }
}
