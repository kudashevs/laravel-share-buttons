<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters\Formatters;

class SimpleAttributesFormatter implements AttributesFormatter
{
    protected const KNOWN_ATTRIBUTE_FORMATS = [
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

        // Since we need all the attributes to be present in the result, we iterate over
        // the attributes listed in the constant, rather than the provided attributes.
        foreach (self::KNOWN_ATTRIBUTE_FORMATS as $name => $format) {
            $formattedAttributes[$name] = isset($attributes[$name])
                ? sprintf($format, trim($attributes[$name]))
                : '';
        }

        return $formattedAttributes;
    }
}
