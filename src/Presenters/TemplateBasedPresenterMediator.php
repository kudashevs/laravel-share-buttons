<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

use Kudashevs\ShareButtons\Exceptions\InvalidOptionValue;
use Kudashevs\ShareButtons\Templaters\SimpleColonTemplater;
use Kudashevs\ShareButtons\Templaters\Templater;

class TemplateBasedPresenterMediator implements ShareButtonsPresenter
{
    /**
     * @var class-string<Templater>
     */
    const DEFAULT_TEMPLATER_CLASS = SimpleColonTemplater::class;

    protected Templater $templater;

    protected TemplateBasedBlockPresenter $blockPresenter;

    protected TemplateBasedElementPresenter $elementPresenter;

    protected TemplateBasedUrlPresenter $urlPresenter;

    /**
     * @param array{templater?: class-string, url_templater?: class-string} $options
     *
     * @throws InvalidOptionValue
     */
    public function __construct(array $options = [])
    {
        $this->initMediator($options);
    }

    /**
     * @param array{templater?: class-string, url_templater?: class-string} $options
     *
     * @throws InvalidOptionValue
     */
    protected function initMediator(array $options): void
    {
        $this->blockPresenter = new TemplateBasedBlockPresenter();

        $urlTemplaterClass = $options['url_templater'] ?? self::DEFAULT_TEMPLATER_CLASS;
        $urlTemplaterInstance = $this->createTemplater($urlTemplaterClass);
        $this->urlPresenter = new TemplateBasedUrlPresenter($urlTemplaterInstance);

        $templaterClass = $options['templater'] ?? self::DEFAULT_TEMPLATER_CLASS;
        $templaterInstance = $this->createTemplater($templaterClass);
        $this->elementPresenter = new TemplateBasedElementPresenter($templaterInstance);
    }

    /**
     * @throws InvalidOptionValue
     */
    protected function createTemplater(string $class): Templater
    {
        /** @var class-string<Templater> $class */
        if (!$this->isValidTemplater($class)) {
            throw new InvalidOptionValue(
                sprintf(
                    '%s is not a valid templater class. Check if it implements the Templater interface.',
                    $class
                )
            );
        }

        return new $class();
    }

    private function isValidTemplater(string $class): bool
    {
        return class_exists($class) && is_a($class, Templater::class, true);
    }

    /**
     * @inheritDoc
     */
    public function refresh(array $options): void
    {
        $this->blockPresenter->refresh($options);
        $this->elementPresenter->refresh($options);
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix(): string
    {
        return $this->blockPresenter->getBlockPrefix();
    }

    /**
     * @inheritDoc
     */
    public function getBlockSuffix(): string
    {
        return $this->blockPresenter->getBlockSuffix();
    }

    /**
     * @inheritDoc
     */
    public function getElementPrefix(): string
    {
        return $this->elementPresenter->getElementPrefix();
    }

    /**
     * @inheritDoc
     */
    public function getElementSuffix(): string
    {
        return $this->elementPresenter->getElementSuffix();
    }

    /**
     * @inheritDoc
     */
    public function getElementBody(string $name, array $arguments): string
    {
        $preparedArguments = $this->prepareElementArguments($name, $arguments);

        return $this->elementPresenter->getElementBody($name, $preparedArguments);
    }

    /**
     * Prepare element's arguments. The preparation process includes:
     * - convert a provided URL to a representation of the element's URL
     *
     * @param array{url: string, text: string, id?: string, class?: string, title?: string, rel?: string, summary?: string} $arguments
     * @return array{url: string, text: string, id?: string, class?: string, title?: string, rel?: string, summary?: string}
     */
    protected function prepareElementArguments(string $name, array $arguments): array
    {
        return array_merge(
            $arguments,
            ['url' => $this->getElementUrl($name, $arguments)],
        );
    }

    /**
     * @inheritDoc
     */
    public function getElementUrl(string $name, array $arguments): string
    {
        return $this->urlPresenter->generateUrl($name, $arguments);
    }
}
