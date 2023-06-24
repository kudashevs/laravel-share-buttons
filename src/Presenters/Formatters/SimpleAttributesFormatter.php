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
     * {@inheritDoc}
     *
     * @param array<string, string> $attributes
     * @return array<string, string>
     */
    public function format(array $attributes): array
    {
        $formattedAttributes = [];

        // We iterate over the constant, but not a parameter, because
        // we want all the known attributes to be present in the result.
        foreach (self::KNOWN_ATTRIBUTE_FORMATS as $name => $format) {
            $formattedAttributes[$name] = isset($attributes[$name])
                ? sprintf($format, trim($attributes[$name]))
                : '';
        }

        return $formattedAttributes;
    }
}
