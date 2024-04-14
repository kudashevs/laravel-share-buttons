<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Templaters;

/**
 * It represents an abstraction of a simple template engine.
 */
interface Templater
{
    /**
     * Process a template and return a result.
     *
     * @param string $template
     * @param array<string, string> $replacements
     * @return string
     */
    public function process(string $template, array $replacements): string;
}
