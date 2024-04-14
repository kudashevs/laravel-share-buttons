<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

use Kudashevs\ShareButtons\Exceptions\InvalidTemplaterFactoryArgument;
use Kudashevs\ShareButtons\Factories\TemplaterFactory;
use Kudashevs\ShareButtons\Templaters\Templater;

class TemplateBasedPresenterMediator implements ShareButtonsPresenter
{
    protected Templater $templater;

    protected TemplateBasedBlockPresenter $blockPresenter;

    protected TemplateShareButtonsPresenter $presenter;

    protected TemplateShareButtonsUrlPresenter $urlPresenter;

    /**
     * @param array{templater?: class-string, urlTemplater?: class-string} $options
     *
     * @throws InvalidTemplaterFactoryArgument
     */
    public function __construct(array $options = [])
    {
        $this->initTemplater($options);
        $this->initBlockPresenter($options);
        $this->initPresenter($options);
        $this->initUrlPresenter($options);
    }

    /**
     * @param array{templater?: class-string, urlTemplater?: class-string} $options
     *
     * @throws InvalidTemplaterFactoryArgument
     */
    protected function initTemplater(array $options): void
    {
        $this->templater = TemplaterFactory::createFromOptions($options);
    }

    /**
     * @param array{} $options
     */
    protected function initBlockPresenter(array $options): void
    {
        $this->blockPresenter = new TemplateBasedBlockPresenter($options);
    }

    /**
     * @param array{templater?: class-string, urlTemplater?: class-string} $options
     */
    protected function initPresenter(array $options): void
    {
        $this->presenter = new TemplateShareButtonsPresenter($options);
    }

    /**
     * @param array{templater?: class-string, urlTemplater?: class-string} $options
     */
    protected function initUrlPresenter(array $options): void
    {
        $this->urlPresenter = new TemplateShareButtonsUrlPresenter($options);
    }

    public function refresh(array $options): void
    {
        $this->blockPresenter->refresh($options);
        $this->presenter->refresh($options);
    }

    public function getBlockPrefix(): string
    {
        return $this->blockPresenter->getBlockPrefix();
    }

    public function getBlockSuffix(): string
    {
        return $this->blockPresenter->getBlockSuffix();
    }

    public function getElementPrefix(): string
    {
        return $this->presenter->getElementPrefix();
    }

    public function getElementSuffix(): string
    {
        return $this->presenter->getElementSuffix();
    }

    public function getElementBody(string $name, array $arguments): string
    {
        return $this->presenter->getElementBody($name, $arguments);
    }

    public function getElementUrl(string $name, array $arguments): string
    {
        return $this->urlPresenter->generateUrl($name, $arguments);
    }
}
