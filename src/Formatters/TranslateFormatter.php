<?php

namespace Kudashevs\ShareButtons\Formatters;

class TranslateFormatter implements Formatter
{
    /**
     * @var array
     */
    private $options = [
        'formatter_version' => '',
        'block_prefix' => '',
        'block_suffix' => '',
        'element_prefix' => '',
        'element_suffix' => '',
    ];

    /**
     * TranslateFormatter constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
       $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function updateOptions(array $options): void
    {
        // TODO: Implement updateOptions() method.
    }

    /**
     * @param string $utl
     * @param array $options
     * @return string
     */
    public function generateUrl(string $utl, array $options): string
    {
        // TODO: Implement generateUrl() method.
    }
}
