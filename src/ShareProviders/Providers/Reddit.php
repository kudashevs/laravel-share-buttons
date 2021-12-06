<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

class Reddit implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $title = empty($options['title']) ? config('laravel-share.services.reddit.text') : $options['title'];

        $providersUrl = config('laravel-share.services.reddit.url');

        return $providersUrl . '?title=' . urlencode($title) . '&url=' . $url;
    }
}
