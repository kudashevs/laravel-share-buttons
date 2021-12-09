<?php

namespace Kudashevs\ShareButtons\Formatters;

interface Formatter
{
    /**
     * @param array $options
     * @return void|bool
     */
    public function updateOptions(array $options);

    /**
     * @return array
     */
    public function getOptions(): array;

    /**
     * @param string $provider
     * @param string $url
     * @param array $options
     * @return string
     */
    public function formatElement(string $provider, string $url, array $options): string;
}
