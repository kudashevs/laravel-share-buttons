<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

use Kudashevs\ShareButtons\Presenters\Formatters\AttributesFormatter;
use Kudashevs\ShareButtons\Presenters\Formatters\DefaultAttributesFormatter;
use Kudashevs\ShareButtons\Templaters\Templater;

class TemplateBasedElementPresenter
{
    protected Templater $templater;

    protected AttributesFormatter $formatter;

    /**
     * Contain options related to the representation of share buttons.
     *
     * @var array{element_prefix: string, element_suffix: string}
     */
    protected array $styling = [
        'element_prefix' => '',
        'element_suffix' => '',
    ];

    /**
     * Contain attributes passed to the page() method (the global attributes). These attributes will be
     * automatically applied to all the elements in the case where no specific attributes are provided.
     *
     * @var array{class?: string, id?: string, title?: string, rel?: string}
     */
    protected array $attributes = [];

    public function __construct(Templater $templater)
    {
        $this->templater = $templater;

        $this->initAttributesFormatter();

        $this->initRepresentation();
    }

    protected function initAttributesFormatter(): void
    {
        $this->formatter = new DefaultAttributesFormatter();
    }

    /**
     * @param array{element_prefix?: string, element_suffix?: string, id?: string, class?: string, title?: string, rel?: string} $options
     */
    protected function initRepresentation(array $options = []): void
    {
        $applicable = $this->retrieveApplicableOptions($options);

        $this->initElementRepresentation($applicable);
        $this->initElementAttributes($applicable);
    }

    /**
     * @param array<string, string> $options
     * @return array<string, string>
     */
    protected function retrieveApplicableOptions(array $options): array
    {
        return array_filter($options, 'is_string');
    }

    /**
     * @param array{element_prefix?: string, element_suffix?: string} $options
     */
    protected function initElementRepresentation(array $options): void
    {
        $this->styling['element_prefix'] = $options['element_prefix'] ?? config('share-buttons.element_prefix', '<li>');
        $this->styling['element_suffix'] = $options['element_suffix'] ?? config('share-buttons.element_suffix', '</li>');
    }

    /**
     * @param array{id?: string, class?: string, title?: string, rel?: string} $options
     */
    protected function initElementAttributes(array $options): void
    {
        $this->attributes = array_diff_key($options, $this->styling);
    }

    /**
     * Refresh styling (style of elements representation) of the share buttons.
     *
     * @param array{element_prefix?: string, element_suffix?: string, id?: string, class?: string, title?: string, rel?: string} $options
     * @return void
     */
    public function refresh(array $options = []): void
    {
        $this->initRepresentation($options);
    }

    /**
     * @see TemplateBasedPresenterMediator::getElementPrefix()
     */
    public function getElementPrefix(): string
    {
        return $this->styling['element_prefix'];
    }

    /**
     * @see TemplateBasedPresenterMediator::getElementSuffix()
     */
    public function getElementSuffix(): string
    {
        return $this->styling['element_suffix'];
    }

    /**
     * @param array{url: string, text: string, id?: string, class?: string, title?: string, rel?: string, summary?: string} $arguments
     * @see TemplateBasedPresenterMediator::getElementBody()
     */
    public function getElementBody(string $name, array $arguments): string
    {
        $template = $this->retrieveElementTemplate($name);
        $replacements = $this->retrieveReplacements($arguments);

        return $this->templater->process($template, $replacements);
    }

    protected function retrieveElementTemplate(string $name): string
    {
        return config('share-buttons.templates.' . $name, '');
    }

    /**
     * @param array{url: string, text: string, id?: string, class?: string, title?: string, rel?: string, summary?: string} $arguments
     * @return array{url: string, id: string, class: string, title: string, rel: string}
     */
    protected function retrieveReplacements(array $arguments): array
    {
        $elementAttributes = $this->prepareAttributes($arguments);

        return array_merge([
            'url' => $arguments['url'],
        ], $elementAttributes);
    }

    /**
     * Prepare element's attributes. The preparation process includes:
     * - format the attributes according to the formatter's rules
     *
     * @param array{url: string, text: string, id?: string, class?: string, title?: string, rel?: string, summary?: string} $arguments
     * @return array{class: string, id: string, title: string, rel: string}
     */
    protected function prepareAttributes(array $arguments): array
    {
        $attributes = array_merge($this->attributes, $arguments);

        return $this->formatter->format($attributes);
    }
}
