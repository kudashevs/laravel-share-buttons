<?php

namespace Kudashevs\ShareButtons\Formatters;

use Kudashevs\ShareButtons\Templaters\ColonTemplater;
use Kudashevs\ShareButtons\Templaters\Templater;

class TemplateFormatter implements Formatter
{
    private const ELEMENT_TAGS = [
        'class' => ' %s',
        'id' => ' id="%s"',
        'title' => ' title="%s"',
        'rel' => ' rel="%s"',
    ];

    /**
     * @var Templater
     */
    private $templater;

    /**
     * Contain formatter options.
     *
     * @var array
     */
    private $options = [
        'block_prefix' => null,
        'block_suffix' => null,
        'element_prefix' => null,
        'element_suffix' => null,
    ];

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
        $this->initElementStyling($options);
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
    private function initElementStyling(array $options): void
    {
        $allowed = $this->filterElementStyling($options);

        $this->options = array_merge($this->options, $allowed);
    }

    /**
     * @param array $options
     * @return array
     */
    private function filterElementStyling(array $options): array
    {
        return array_intersect_key($options, self::ELEMENT_TAGS);
    }

    /**
     * @inheritDoc
     */
    public function formatElement(string $provider, string $url, array $options = []): string
    {
        $providerArguments = $this->filterElementStyling($options);

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
        $styling = $this->prepareElementStyling($url, $options);

        return $this->templater->process($template, $styling);
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
    private function prepareElementStyling(string $url, array $options): array
    {
        $styling = array_merge($this->options, $options);

        return $this->prepareElementWithTags($url, $styling);
    }

    /**
     * @param string $url
     * @param array $options
     * @return array
     */
    private function prepareElementWithTags(string $url, array $options): array
    {
        $tags = [
            'url' => $url,
        ];

        foreach (self::ELEMENT_TAGS as $tagName => $tagTemplate) {
            $tags[$tagName] = array_key_exists($tagName, $options)
                ? sprintf($tagTemplate, $options[$tagName])
                : '';
        }

        return $tags;
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
