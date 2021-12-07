<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Telegram implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $title = empty($options['title']) ? config('share-buttons.providers.telegram.text') : $options['title'];

        $providersUrl = config('share-buttons.providers.telegram.url');

        return $providersUrl . '?url=' . $url . '&text=' . urlencode($title);
    }
}
