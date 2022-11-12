<?php

namespace Kudashevs\ShareButtons\Formatters;

use Kudashevs\ShareButtons\Templaters\ColonTemplater;
use Kudashevs\ShareButtons\Templaters\Templater;

class TemplateFormatter implements Formatter
{
    private const DIFFERENT_ATTRIBUTE_FORMATS = [
        'class' => ' %s',
        'id' => ' id="%s"',
        'title' => ' title="%s"',
        'rel' => ' rel="%s"',
    ];

    private Templater $templater;

    /**
     * Contain formatter options.
     */
    private array $options = [
        'block_prefix' => '',
        'block_suffix' => '',
        'element_prefix' => '',
        'element_suffix' => '',
    ];

    /**
     * Contain global element attributes. These are attributes passed to the ShareButtons main method.
     * They will be applied to all the elements, however, if necessary, they could be overridden by
     * the attributes provided to any specific share service methods.
    */
    private array $attributes = [];

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

    private function initTemplater(): void
    {
        $this->templater = $this->createTemplater();
    }

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

    private function initBlockWrapping(array $options): void
    {
        $this->options['block_prefix'] = $options['block_prefix'] ?? config('share-buttons.block_prefix', '<ul>');
        $this->options['block_suffix'] = $options['block_suffix'] ?? config('share-buttons.block_suffix', '</ul>');
    }

    private function initElementWrapping(array $options): void
    {
        $this->options['element_prefix'] = $options['element_prefix'] ?? config('share-buttons.element_prefix', '<li>');
        $this->options['element_suffix'] = $options['element_suffix'] ?? config('share-buttons.element_suffix', '</li>');
    }

    private function initElementAttributes(array $options): void
    {
        $this->attributes = $options;
    }

    /**
     * @inheritDoc
     */
    public function formatElement(string $provider, string $url, array $options = []): string
    {
        $template = $this->retrieveElementTemplate($provider);
        $replacements = $this->retrieveElementReplacements($url, $options);

        return $this->templater->process($template, $replacements);
    }

    private function retrieveElementTemplate(string $provider): string
    {
        return config('share-buttons.templates.' . $provider, '');
    }

    /**
     * @return array
     */
    private function retrieveElementReplacements(string $url, array $options): array
    {
        $attributes = $this->retrieveAttributes($options);

        $replacements = ['url' => $url];
        foreach ($attributes as $name => $format) {
            $replacements[$name] = $this->formatElementAttribute($name, $format);
        }

        return $replacements;
    }

    /**
     * @return array<string, string>
     */
    private function retrieveAttributes(array $options): array
    {
        return array_merge($this->attributes, $options);
    }

    /**
     * @return array<string, string>
     */
    private function prepareElementAttributes(array $options): array
    {
        $existingAttributes = $this->retrieveExistingAttributes();

        return array_intersect_key($options, $existingAttributes) + $existingAttributes;
    }

    /**
     * @return array<string, string>
     */
    private function retrieveExistingAttributes(): array
    {
        return array_fill_keys(array_keys(self::DIFFERENT_ATTRIBUTE_FORMATS), '');
    }

    private function formatElementAttribute(string $name, string $value): string
    {
        if ($value === '') {
            return '';
        }

        $format = ' ' . self::DIFFERENT_ATTRIBUTE_FORMATS[$name];

        return sprintf($format, $value);
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
