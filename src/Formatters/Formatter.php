<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Formatters;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

interface Formatter
{
    /**
     * @param array $options
     * @return void|bool
     */
    public function updateOptions(array $options);

    /**
     * @param ShareProvider $provider
     * @return string
     */
    public function getElementBody(ShareProvider $provider): string;

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
}
