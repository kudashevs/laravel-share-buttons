<?php

namespace Kudashevs\ShareButtons\Formatters;

class TranslateFormatter implements Formatter
{
    /**
     * Contain formatter options.
     *
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
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->updateOptions($options);
    }

    /**
     * @inheritDoc
     */
    public function updateOptions(array $options): void
    {
        $this->initFontAwesomeVersion($options);
        $this->initFormatterStyling($options);
        $this->initElementStylingFromOptions($options);
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
        $this->options['block_prefix'] = $this->setFormatterBlockPrefix($options);
        $this->options['block_suffix'] = $this->setFormatterBlockSuffix($options);
        $this->options['element_prefix'] = $this->setFormatterElementPrefix($options);
        $this->options['element_suffix'] = $this->setFormatterElementSuffix($options);
    }

    /**
     * @param array $options
     * @return string
     */
    private function setFormatterBlockPrefix(array $options): string
    {
        return $options['block_prefix'] ?? config('share-buttons.block_prefix', '<ul>');
    }

    /**
     * @param array $options
     * @return string
     */
    private function setFormatterBlockSuffix(array $options): string
    {
        return $options['block_suffix'] ?? config('share-buttons.block_suffix', '</ul>');
    }

    /**
     * @param array $options
     * @return string
     */
    private function setFormatterElementPrefix(array $options): string
    {
        return $options['element_prefix'] ?? config('share-buttons.element_prefix', '<li>');
    }

    /**
     * @param array $options
     * @return string
     */
    private function setFormatterElementSuffix(array $options): string
    {
        return $options['element_suffix'] ?? config('share-buttons.element_suffix', '</li>');
    }

    /**
     * @param array $options
     */
    private function initElementStylingFromOptions(array $options): void
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
        $elementStyling = [
            'class' => '',
            'id' => '',
            'title' => '',
            'rel' => '',
        ];

        return array_intersect_key($options, $elementStyling);
    }

    /**
     * @inheritDoc
     */
    public function formatElement(string $provider, string $url, array $options = []): string
    {
        $providerArguments = $this->initElementStyling($options);

        return $this->generateLink($provider, $url, $providerArguments);
    }

    /**
     * @param string $provider
     * @param string $url
     * @param array $options
     * @return string
     */
    private function generateLink(string $provider, string $url, array $options): string
    {
        $template = $this->prepareElementTemplate($provider);
        $styling = $this->prepareElementStyling($options);

        return trans(
            $template,
            [
                'url' => $url,
                'class' => !empty($styling['class']) ? (' ' . $styling['class']) : '',
                'id' => !empty($styling['id']) ? (' id="' . $styling['id'] . '"') : '',
                'title' => !empty($styling['title']) ? (' title="' . $styling['title'] . '"') : '',
                'rel' => !empty($styling['rel']) ? (' rel="' . $styling['rel'] . '"') : '',
            ]);
    }

    /**
     * @param string $provider
     * @return string
     */
    private function prepareElementTemplate(string $provider): string
    {
        return "share-buttons::share-buttons-fontawesome-{$this->options['formatter_version']}.{$provider}";
    }

    /**
     * @param array $options
     * @return array
     */
    private function prepareElementStyling(array $options): array
    {
        return array_merge($this->options, $options);
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix(): string
    {
        return $this->options['block_prefix'];
    }

    /**
     * @inheritDoc
     */
    public function getBlockSuffix(): string
    {
        return $this->options['block_suffix'];
    }

    /**
     * @inheritDoc
     */
    public function getElementPrefix(): string
    {
        return $this->options['element_prefix'];
    }

    /**
     * @inheritDoc
     */
    public function getElementSuffix(): string
    {
        return $this->options['element_suffix'];
    }
}
