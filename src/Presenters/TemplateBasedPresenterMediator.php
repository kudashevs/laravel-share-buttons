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
        $this->blockPresenter = new TemplateBasedBlockPresenter($options);

        $templaterClass1 = $options['url_templater'] ?? self::DEFAULT_TEMPLATER_CLASS;
        $templaterInstance1 = $this->createTemplater($templaterClass1);
        $this->urlPresenter = new TemplateBasedUrlPresenter($templaterInstance1);

        $templaterClass = $options['templater'] ?? self::DEFAULT_TEMPLATER_CLASS;
        $templaterInstance = $this->createTemplater($templaterClass);
        $this->elementPresenter = new TemplateBasedElementPresenter($templaterInstance);
    }

    /**
     * @throws InvalidOptionValue
     */
    protected function createTemplater(string $class): Templater
    {
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

    public function refresh(array $options): void
    {
        $this->blockPresenter->refresh($options);
        $this->elementPresenter->refresh($options);
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
        return $this->elementPresenter->getElementPrefix();
    }

    public function getElementSuffix(): string
    {
        return $this->elementPresenter->getElementSuffix();
    }

    public function getElementBody(string $name, array $arguments): string
    {
        return $this->elementPresenter->getElementBody($name, $arguments);
    }

    public function getElementUrl(string $name, array $arguments): string
    {
        return $this->urlPresenter->generateUrl($name, $arguments);
    }
}
