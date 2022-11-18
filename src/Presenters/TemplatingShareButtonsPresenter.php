<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

use Kudashevs\ShareButtons\Factories\TemplaterFactory;
use Kudashevs\ShareButtons\ShareProviders\ShareProvider;
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
        $this->initTemplater($options);
        $this->initOptions($options);
    }

    private function initTemplater(array $options): void
    {
        $this->templater = TemplaterFactory::createFromOptions($options);
    }

    private function initOptions(array $options): void
    {
        $this->refreshStyling(
            $this->retrieveApplicableOptions($options)
        );
    }

    /**
     * @return array<string, string>
     */
    protected function retrieveApplicableOptions(array $options): array
    {
        return array_filter($options, function ($option, $name) {
            return isset($this->options[$name]) &&
                gettype($this->options[$name]) === gettype($option);
        }, ARRAY_FILTER_USE_BOTH);
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

    /**
     * @inheritDoc
     */
    public function refreshStyling(array $options): void
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
        $this->attributes = array_diff_key($options, $this->options);
    }

    /**
     * @inheritDoc
     */
    public function getElementBody(ShareProvider $provider): string
    {
        $url = $this->getElementUrl($provider);

        $template = $this->retrieveElementTemplate($provider->getName());
        $replacements = $this->retrieveElementReplacements($url, $provider->getArguments());

        return $this->templater->render($template, $replacements);
    }

    public function getElementUrl(ShareProvider $provider): string
    {
        $template = $provider->getUrl();
        $replacements = $provider->getReplacements();

        return $this->templater->render($template, $replacements);
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
}
