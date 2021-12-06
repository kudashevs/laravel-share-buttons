<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

class Pinterest implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $repository = config('laravel-share.services.pinterest.uri');

        return $repository . $url;
    }
}
