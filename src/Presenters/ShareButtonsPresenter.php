<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

/**
 * It represents an abstraction that is responsible for a visual representation of the social media buttons.
 */
interface ShareButtonsPresenter
{
    /**
     * Refresh styling (the style of elements) of share buttons.
     *
     * @param array{block_prefix?: string, block_suffix?: string, element_prefix?: string, element_suffix?: string, id?: string, class?: string, title?: string, rel?: string} $options
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
     * @param array{url: string, text: string, id?: string, class?: string, title?: string, rel?: string, summary?: string} $arguments
     * @return string
     */
    public function getElementBody(string $name, array $arguments): string;

    /**
     * Return a representation of an element's URL.
     *
     * @param string $name
     * @param array{url: string, text: string, summary?: string} $arguments
     * @return string
     */
    public function getElementUrl(string $name, array $arguments): string;
}
