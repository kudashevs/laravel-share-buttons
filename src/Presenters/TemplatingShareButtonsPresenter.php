<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;
use Kudashevs\ShareButtons\Templaters\ColonTemplater;
use Kudashevs\ShareButtons\Templaters\Templater;

class TemplatingShareButtonsPresenter implements ShareButtonsPresenter
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
        $this->initOptions($options);
    }

    private function initTemplater(): void
    {
        $this->templater = $this->createTemplater();
    }

    private function createTemplater(): Templater
    {
        return new ColonTemplater();
    }

    private function initOptions(array $options): void
    {
        $this->updateOptions($options);
    }

    /**
     * @inheritDoc
     */
    public function updateOptions(array $options): void
    {
        $this->initBlockWrappers($options);
        $this->initElementWrappers($options);
        $this->initElementAttributes($options);
    }

    private function initBlockWrappers(array $options): void
    {
        $this->options['block_prefix'] = $options['block_prefix'] ?? config('share-buttons.block_prefix', '<ul>');
        $this->options['block_suffix'] = $options['block_suffix'] ?? config('share-buttons.block_suffix', '</ul>');
    }

    private function initElementWrappers(array $options): void
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
    public function getElementBody(ShareProvider $provider): string
    {
        $template = $this->retrieveElementTemplate($provider->getName());
        $replacements = $this->retrieveElementReplacements($provider->getUrl(), $provider->getOptions());

        return $this->templater->process($template, $replacements);
    }

    private function retrieveElementTemplate(string $provider): string
    {
        return config('share-buttons.templates.' . $provider, '');
    }

    /**
     * @return array<string, string>
     */
    private function retrieveElementReplacements(string $url, array $options): array
    {
        $replacements = ['url' => $url];
        $attributes = $this->retrieveAttributes($options);

        return array_merge(
            $replacements,
            $attributes,
        );
    }

    /**
     * @return array<string, string>
     */
    private function retrieveAttributes(array $options): array
    {
        $attributes = array_merge($this->attributes, $options);

        return $this->formatAttributes($attributes);
    }

    private function formatAttributes(array $attributes): array
    {
        $formattedAttributes = [];
        foreach (self::DIFFERENT_ATTRIBUTE_FORMATS as $name => $format) {
            $formattedAttributes[$name] = isset($attributes[$name])
                ? sprintf($format, $attributes[$name])
                : '';
        }

        return $formattedAttributes;
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
