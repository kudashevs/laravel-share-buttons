<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

class Telegram implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $title = empty($options['title']) ? config('laravel-share.services.telegram.text') : $options['title'];

        $providersUrl = config('laravel-share.services.telegram.uri');

        return $providersUrl . '?url=' . $url . '&text=' . urlencode($title);
    }
}
