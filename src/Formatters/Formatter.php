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
     * @param string $utl
     * @param array $options
     * @return string
     */
    public function generateUrl(string $utl, array $options): string;
}
