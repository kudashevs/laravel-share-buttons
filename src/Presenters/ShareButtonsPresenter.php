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
    public function refreshStyling(array $options);

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
