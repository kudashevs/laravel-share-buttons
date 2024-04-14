<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

use Kudashevs\ShareButtons\Exceptions\InvalidTemplaterFactoryArgument;
use Kudashevs\ShareButtons\Factories\TemplaterFactory;
use Kudashevs\ShareButtons\Presenters\Formatters\AttributesFormatter;
use Kudashevs\ShareButtons\Presenters\Formatters\DefaultAttributesFormatter;
use Kudashevs\ShareButtons\Templaters\SimpleColonTemplater;
use Kudashevs\ShareButtons\Templaters\Templater;

class TemplateBasedElementPresenter
{
    protected Templater $templater;

    protected TemplateBasedUrlPresenter $urlPresenter;

    protected AttributesFormatter $formatter;

    /**
     * Contain options related to the representation of share buttons.
     *
     * @var array{'block_prefix': string, 'block_suffix': string, 'element_prefix': string, 'element_suffix': string}
     */
    protected array $styling = [
        'element_prefix' => '',
        'element_suffix' => '',
    ];

    /**
     * Contain attributes passed to the page() method (the global attributes). These attributes will be
     * automatically applied to all the elements in the case where no specific attributes are provided.
     *
     * @var array<string, string>
     */
    protected array $attributes = [];

    public function __construct(Templater $templater)
    {
        $this->templater = $templater;

        $this->initUrlPresenter();
        $this->initAttributesFormatter();

        $this->initRepresentation();
    }

    /**
     * @param array<string, string> $options
     *
     * @throws InvalidTemplaterFactoryArgument
     */
    protected function initTemplater(array $options): void
    {
        $this->templater = TemplaterFactory::createFromOptions($options);
    }

    protected function initUrlPresenter(): void
    {
        $templater = new SimpleColonTemplater(); // @note don't forget to update
        $this->urlPresenter = new TemplateBasedUrlPresenter($templater);
    }

    protected function initAttributesFormatter(): void
    {
        $this->formatter = new DefaultAttributesFormatter();
    }

    /**
     * @param array<string, string> $options
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
     * @param array<string, string> $options
     */
    protected function initElementRepresentation(array $options): void
    {
        $this->styling['element_prefix'] = $options['element_prefix'] ?? config('share-buttons.element_prefix', '<li>');
        $this->styling['element_suffix'] = $options['element_suffix'] ?? config('share-buttons.element_suffix', '</li>');
    }

    /**
     * @param array<string, string> $options
     */
    protected function initElementAttributes(array $options): void
    {
        $this->attributes = array_diff_key($options, $this->styling);
    }

    /**
     * {@inheritDoc}
     *
     * @param array<string, string> $options
     * @return void
     */
    public function refresh(array $options = []): void
    {
        $this->initRepresentation($options);
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
     * {@inheritDoc}
     *
     * @param string $name
     * @param array<string, string> $arguments
     * @return string
     */
    public function getElementBody(string $name, array $arguments): string
    {
        $template = $this->retrieveElementTemplate($name);
        $replacements = $this->retrieveReplacements($name, $arguments);

        return $this->templater->process($template, $replacements);
    }

    protected function retrieveElementTemplate(string $name): string
    {
        return config('share-buttons.templates.' . $name, '');
    }

    /**
     * @param array<string, string> $arguments
     * @return array<string, string>
     */
    protected function retrieveReplacements(string $name, array $arguments): array
    {
        $elementUrl = $this->getElementUrl($name, $arguments);
        $elementAttributes = $this->retrieveAttributes($arguments);

        return array_merge([
            'url' => $elementUrl,
        ], $elementAttributes);
    }

    /**
     * @param array<string, string> $arguments
     * @return array<string, string>
     */
    protected function retrieveAttributes(array $arguments): array
    {
        $attributes = array_merge($this->attributes, $arguments);

        return $this->formatter->format($attributes);
    }

    /**
     * {@inheritDoc}
     *
     * @param string $name
     * @param array<string, string> $arguments
     * @return string
     */
    public function getElementUrl(string $name, array $arguments): string
    {
        return $this->urlPresenter->generateUrl($name, $arguments);
    }
}
