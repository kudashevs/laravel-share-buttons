<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters\Formatters;

/**
 * It represents an abstraction that formats attributes of a social media button link.
 */
interface AttributesFormatter
{
    /**
     * Format and return formatted attributes.
     *
     * @param array{class?:string, id?: string, title?: string, rel?: string} $attributes
     * @return array{class: string, id: string, title: string, rel: string}
     */
    public function format(array $attributes): array;
}
