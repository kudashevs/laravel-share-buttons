<?php

namespace Kudashevs\ShareButtons\Templater;

interface Templater
{
    /**
     * @param string $line
     * @param array $replacements
     * @return string
     */
    public function process(string $line, array $replacements): string;
}
