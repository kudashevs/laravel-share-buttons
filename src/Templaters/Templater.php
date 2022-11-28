<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Templaters;

interface Templater
{
    /**
     * @param string $template
     * @param array $replacements
     * @return string
     */
    public function process(string $template, array $replacements): string;
}
