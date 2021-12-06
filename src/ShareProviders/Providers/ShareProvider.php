<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

interface ShareProvider
{
    public function buildUrl(string $url, array $options): string;
}
