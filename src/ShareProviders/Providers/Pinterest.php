<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

class Pinterest implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $repository = config('laravel-share.providers.pinterest.url');

        return $repository . $url;
    }
}
