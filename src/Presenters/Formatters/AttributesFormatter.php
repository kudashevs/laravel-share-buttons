<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters\Formatters;

/**
 * AttributesFormatter represents an abstraction that formats attributes of a share buttons element.
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
