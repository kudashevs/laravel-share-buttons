<?php

namespace Kudashevs\ShareButtons\Replacers;

interface Replacer
{
    /**
     * @param string $line
     * @param array $replacements
     * @return string
     */
    public function replace(string $line, array $replacements): string;
}
