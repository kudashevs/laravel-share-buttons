<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

/**
 * ShareButtonsPresenter represents an abstraction that is responsible for a visual representation of the share buttons.
 */
interface ShareButtonsPresenter
{
    /**
     * @param array $options
     * @return void
     */
    public function refresh(array $options): void;

    /**
     * @return string
     */
    public function getBlockPrefix(): string;

    /**
     * @return string
     */
    public function getBlockSuffix(): string;

    /**
     * @return string
     */
    public function getElementPrefix(): string;

    /**
     * @return string
     */
    public function getElementSuffix(): string;

    /**
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public function getElementBody(string $name, array $arguments): string;

    /**
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public function getElementUrl(string $name, array $arguments): string;
}
