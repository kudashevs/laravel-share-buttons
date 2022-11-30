<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\UrlProviders;

/**
 * ShareProvider represents an abstraction that generates a ready-to-use share button URL.
 */
interface ShareButtonsProvider
{
    /**
     * Return a share provider's ready-to-use URL.
     *
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public function generateUrl(string $name, array $arguments): string;
}
