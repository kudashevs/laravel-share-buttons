<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

interface ShareButtonsPresenter
{
    /**
     * @param array $options
     * @return void
     */
    public function refreshRepresentation(array $options): void;

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
