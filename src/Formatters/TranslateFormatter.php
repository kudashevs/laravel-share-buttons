<?php

namespace Kudashevs\ShareButtons\Formatters;

class TranslateFormatter implements Formatter
{
    /**
     * @var array
     */
    private $options = [
        'formatter_version' => '',
        'block_prefix' => null,
        'block_suffix' => null,
        'element_prefix' => null,
        'element_suffix' => null,
    ];

    /**
     * TranslateFormatter constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->updateOptions($options);
    }

    /**
     * @param array $options
     */
    public function updateOptions(array $options): void
    {
        $this->initFontAwesomeVersion($options);
        $this->initFormatterStyling($options);
        $this->initElementStylingForOptions($options);
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
    private function initFormatterStyling(array $options): void
    {
        // the key prefix could be used for convenience and backward compatibility
        if (isset($options['block_prefix']) || isset($options['prefix'])) {
            $this->options['block_prefix'] = $options['block_prefix'] ?? $options['prefix'];
        } else {
            $this->options['block_prefix'] = config('share-buttons.block_prefix', '<ul>');
        }

        // the key prefix could be used for convenience and backward compatibility
        if (isset($options['block_suffix'])|| isset($options['suffix'])) {
            $this->options['block_suffix'] = $options['block_suffix'] ?? $options['suffix'];
        } else {
            $this->options['block_suffix'] = config('share-buttons.block_suffix', '</ul>');
        }

        if (isset($options['element_prefix'])) {
            $this->options['element_prefix'] = $options['element_prefix'];
        } else {
            $this->options['element_prefix'] = config('share-buttons.element_prefix', '<li>');
        }

        if (isset($options['element_suffix'])) {
            $this->options['element_suffix'] = $options['element_suffix'];
        } else {
            $this->options['element_suffix'] = config('share-buttons.element_suffix', '</li>');
        }
    }

    /**
     * @param array $options
     */
    private function initElementStylingForOptions(array $options): void
    {
        $allowed = $this->initElementStyling($options);

        $this->options = array_merge($this->options, $allowed);
    }

    /**
     * @param array $options
     * @return array
     */
    private function initElementStyling(array $options): array
    {
        $massOptions = [
            'class' => '',
            'id' => '',
            'title' => '',
            'rel' => '',
        ];

        return array_intersect_key($options, $massOptions);
    }

    /**
     * @param string $provider
     * @param string $url
     * @param array $options
     * @return string
     */
    public function generateUrl(string $provider, string $url, array $options = []): string
    {
        $this->initMassOptions($options);

        $preparedLink = $this->generateLink($provider, $url);

        return $this->getElementPrefix() . $preparedLink . $this->getElementSuffix();
    }

    /**
     * @param string $provider
     * @param string $url
     * @return string
     */
    private function generateLink(string $provider, string $url): string
    {
        $providerStyles = "share-buttons::share-buttons-fontawesome-{$this->options['formatter_version']}.{$provider}";

        return trans(
            $providerStyles,
            [
                'url' => $url,
                'class' => !empty($this->options['class']) ? (' ' . $this->options['class']) : '',
                'id' => !empty($this->options['id']) ? (' id="' . $this->options['id'] . '"') : '',
                'title' => !empty($this->options['title']) ? (' title="' . $this->options['title'] . '"') : '',
                'rel' => !empty($this->options['rel']) ? (' rel="' . $this->options['rel'] . '"') : '',
            ]);
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return string
     */
    private function getElementPrefix(): string
    {
        return $this->options['element_prefix'];
    }

    /**
     * @return string
     */
    private function getElementSuffix(): string
    {
        return $this->options['element_suffix'];
    }
}
