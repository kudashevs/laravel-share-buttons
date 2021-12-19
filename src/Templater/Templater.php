<?php

namespace Kudashevs\ShareButtons\Templater;

interface Templater
{
    /**
     * @param string $line
     * @param array $replacements
     * @return string
     */
    public function replace(string $line, array $replacements): string;
}
