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
        $this->initFontAwesomeVersion($options);
        $this->initPrefixAndSuffix($options);
    }

    /**
     * @param array $options
     */
    private function initFontAwesomeVersion(array $options): void
    {
        if (!empty($options['fontAwesomeVersion']) && is_int($options['fontAwesomeVersion'])) {
            $this->options['formatter_version'] = $options['fontAwesomeVersion'];

            return;
        }

        $this->options['formatter_version'] = config('share-buttons.fontAwesomeVersion', 5);
    }

    /**
     * @param array $options
     */
    private function initPrefixAndSuffix(array $options)
    {
        if (!empty($options['block_prefix'])) {
            $this->options['block_prefix'] = $options['block_prefix'];
        }

        if (!empty($options['block_suffix'])) {
            $this->options['block_suffix'] = $options['block_suffix'];
        }
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
