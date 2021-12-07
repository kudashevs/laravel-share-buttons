<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Twitter implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $providersUrl = config('share-buttons.providers.twitter.url');

        $title = empty($options['title']) ? config('share-buttons.providers.twitter.text') : $options['title'];

        return $providersUrl . '?text=' . urlencode($title) . '&url=' . $url;
    }
}
