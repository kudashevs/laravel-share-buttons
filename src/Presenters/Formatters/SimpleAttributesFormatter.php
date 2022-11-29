<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters\Formatters;

class SimpleAttributesFormatter implements AttributesFormatter
{
    private const DIFFERENT_ATTRIBUTE_FORMATS = [
        'class' => ' %s',
        'id' => ' id="%s"',
        'title' => ' title="%s"',
        'rel' => ' rel="%s"',
    ];

    /**
     * @inheritDoc
     */
    public function format(array $attributes): array
    {
        $formattedAttributes = [];
        foreach (self::DIFFERENT_ATTRIBUTE_FORMATS as $name => $format) {
            $formattedAttributes[$name] = isset($attributes[$name])
                ? sprintf($format, trim($attributes[$name]))
                : '';
        }

        return $formattedAttributes;
    }
}
