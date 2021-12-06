<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

class Facebook implements ShareProvider
{
    public function buildUrl(string $url, array $options = []): string
    {
        $providersUrl = config('laravel-share.providers.facebook.url');

        return $providersUrl . $url;
    }
}
