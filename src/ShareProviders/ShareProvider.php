<?php

namespace Kudashevs\ShareButtons\ShareProviders;

abstract class ShareProvider
{
    /**
     * @param string $url
     * @param string $title
     * @param array $options
     * @return string
     */
    abstract public function buildUrl(string $url, string $title, array $options): string;
}
