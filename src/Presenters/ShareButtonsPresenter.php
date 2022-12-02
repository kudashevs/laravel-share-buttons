<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

/**
 * ShareButtonsPresenter represents an abstraction that is responsible for a visual representation of the share buttons.
 */
interface ShareButtonsPresenter
{
    /**
     * Refresh styling (style of layout elements) of the share buttons.
     *
     * @param array $options
     * @return void
     */
    public function refresh(array $options): void;

    /**
     * Return a representation of a share buttons start.
     *
     * @return string
     */
    public function getBlockPrefix(): string;

    /**
     * Return a representation of a share buttons end.
     *
     * @return string
     */
    public function getBlockSuffix(): string;

    /**
     * Return a representation of a share buttons element start.
     *
     * @return string
     */
    public function getElementPrefix(): string;

    /**
     * Return a representation of a share buttons element end.
     *
     * @return string
     */
    public function getElementSuffix(): string;

    /**
     * Return a representation of an element's body.
     *
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public function getElementBody(string $name, array $arguments): string;

    /**
     * Return a representation of an element's URL.
     *
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public function getElementUrl(string $name, array $arguments): string;
}
