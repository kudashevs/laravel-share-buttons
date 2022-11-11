<?php

namespace Kudashevs\ShareButtons\Formatters;

interface Formatter
{
    /**
     * @param string $provider
     * @param string $url
     * @param array $options
     * @return string
     */
    public function formatElement(string $provider, string $url, array $options): string;

    /**
     * @param array $options
     * @return void|bool
     */
    public function updateOptions(array $options);

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
