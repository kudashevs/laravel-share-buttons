<?php

namespace Kudashevs\ShareButtons\Formatters;

use Kudashevs\ShareButtons\Templaters\ColonTemplater;
use Kudashevs\ShareButtons\Templaters\Templater;

class TemplateFormatter implements Formatter
{
    private const DIFFERENT_ATTRIBUTE_FORMATS = [
        'class' => '%s',
        'id' => 'id="%s"',
        'title' => 'title="%s"',
        'rel' => 'rel="%s"',
    ];

    private Templater $templater;

    /**
     * Contain formatter options.
     */
    private array $options = [
        'block_prefix' => null,
        'block_suffix' => null,
        'element_prefix' => null,
        'element_suffix' => null,
    ];

    /**
     * Contain global element attributes. These are attributes passed to the ShareButtons main method.
     * They will be applied to all the elements, however, if necessary, they could be overridden by
     * the attributes provided to any specific share service methods.
     *
     * @var array
     */
    private $attributes = [];

    /**
     * TemplateFormatter constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->initTemplater();

        $this->updateOptions($options);
    }

    /**
     * @return void
     */
    private function initTemplater(): void
    {
        $this->templater = $this->createTemplater();
    }

    /**
     * @return Templater
     */
    private function createTemplater(): Templater
    {
        return new ColonTemplater();
    }

    /**
     * @inheritDoc
     */
    public function updateOptions(array $options): void
    {
        $this->initBlockWrapping($options);
        $this->initElementWrapping($options);
        $this->initElementAttributes($options);
    }

    /**
     * @param array $options
     */
    private function initBlockWrapping(array $options): void
    {
        $this->options['block_prefix'] = $options['block_prefix'] ?? config('share-buttons.block_prefix', '<ul>');
        $this->options['block_suffix'] = $options['block_suffix'] ?? config('share-buttons.block_suffix', '</ul>');
    }

    /**
     * @param array $options
     */
    private function initElementWrapping(array $options): void
    {
        $this->options['element_prefix'] = $options['element_prefix'] ?? config('share-buttons.element_prefix', '<li>');
        $this->options['element_suffix'] = $options['element_suffix'] ?? config('share-buttons.element_suffix', '</li>');
    }

    /**
     * @param array $options
     */
    private function initElementAttributes(array $options): void
    {
        $this->attributes = $options;
    }

    /**
     * @inheritDoc
     */
    public function formatElement(string $provider, string $url, array $options = []): string
    {
        $template = $this->prepareElementTemplate($provider);
        $replacements = $this->prepareElementReplacements($url, $options);

        return $this->templater->process($template, $replacements);
    }

    /**
     * @param string $provider
     * @return string
     */
    private function prepareElementTemplate(string $provider): string
    {
        return config('share-buttons.templates.' . $provider);
    }

    /**
     * @param string $url
     * @param array $options
     * @return array
     */
    private function prepareElementReplacements(string $url, array $options): array
    {
        $replacements = ['url' => $url];
        foreach ($this->prepareElementAttributes($options) as $name => $format) {
            $replacements[$name] = $this->formatElementAttribute($name, $format);
        }

        return $replacements;
    }

    /**
     * @param array $options
     * @return array
     */
    private function prepareElementAttributes(array $options): array
    {
        $combinedAttributes = array_merge($this->attributes, $options);

        return $this->amendElementAttributes($combinedAttributes);
    }

    /**
     * @param array $options
     * @return array
     */
    private function amendElementAttributes(array $options): array
    {
        $allExistingAttributes = array_fill_keys(array_keys(self::DIFFERENT_ATTRIBUTE_FORMATS), '');

        return array_intersect_key($options, $allExistingAttributes) + $allExistingAttributes;
    }

    /**
     * @param string $name
     * @param string $value
     * @return string
     */
    private function formatElementAttribute(string $name, string $value): string
    {
        if ($value === '') {
            return '';
        }

        $format = ' ' . self::DIFFERENT_ATTRIBUTE_FORMATS[$name];

        return sprintf($format, $value);
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
