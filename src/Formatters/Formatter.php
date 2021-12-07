<?php

namespace Kudashevs\ShareButtons\Formatters;

interface Formatter
{
    /**
     * @param array $options
     * @return mixed
     */
    public function updateOptions(array $options);

    /**
     * @param string $provider
     * @param string $url
     * @param array $options
     * @return string
     */
    public function generateUrl(string $provider, string $url, array $options): string;
}
