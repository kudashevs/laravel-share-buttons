<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

use Kudashevs\ShareButtons\Exceptions\InvalidTemplaterFactoryArgument;
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
    private array $styling = [
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
     * @param array $options
     *
     * @throws InvalidTemplaterFactoryArgument
     */
    public function __construct(array $options = [])
    {
        $this->initTemplater($options);
        $this->initStyling($options);
    }

    /**
     * @throws InvalidTemplaterFactoryArgument
     */
    private function initTemplater(array $options): void
    {
        $this->templater = TemplaterFactory::createFromOptions($options);
    }

    private function initStyling(array $options): void
    {
        $applicable = $this->retrieveApplicableOptions($options);

        $this->initBlockWrappers($applicable);
        $this->initElementWrappers($applicable);
        $this->initElementAttributes($applicable);
    }

    /**
     * @return array<string, string>
     */
    protected function retrieveApplicableOptions(array $options): array
    {
        return array_filter($options, 'is_string');
    }

    private function initBlockWrappers(array $options): void
    {
        $this->styling['block_prefix'] = $options['block_prefix'] ?? config('share-buttons.block_prefix', '<ul>');
        $this->styling['block_suffix'] = $options['block_suffix'] ?? config('share-buttons.block_suffix', '</ul>');
    }

    private function initElementWrappers(array $options): void
    {
        $this->styling['element_prefix'] = $options['element_prefix'] ?? config('share-buttons.element_prefix', '<li>');
        $this->styling['element_suffix'] = $options['element_suffix'] ?? config('share-buttons.element_suffix', '</li>');
    }

    private function initElementAttributes(array $options): void
    {
        $this->attributes = array_diff_key($options, $this->styling);
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix(): string
    {
        return $this->styling['block_prefix'];
    }

    /**
     * @inheritDoc
     */
    public function getBlockSuffix(): string
    {
        return $this->styling['block_suffix'];
    }

    /**
     * @inheritDoc
     */
    public function getElementPrefix(): string
    {
        return $this->styling['element_prefix'];
    }

    /**
     * @inheritDoc
     */
    public function getElementSuffix(): string
    {
        return $this->styling['element_suffix'];
    }

    /**
     * @inheritDoc
     */
    public function refreshStyling(array $options): void
    {
        $this->initStyling($options);
    }

    /**
     * @inheritDoc
     */
    public function getElementBody(ShareProvider $provider, array $arguments): string
    {
        $url = $this->getElementUrl($provider, $arguments);

        $template = $this->retrieveElementTemplate($provider->getName());
        $replacements = $this->retrieveElementReplacements($url, $arguments);

        return $this->templater->render($template, $replacements);
    }

    /**
     * @inheritDoc
     */
    public function getElementUrl(ShareProvider $provider, array $arguments): string
    {
        $template = $provider->getUrl();
        $replacements = array_merge($provider->getUrlReplacements(), array_filter($arguments, 'strlen'));

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
