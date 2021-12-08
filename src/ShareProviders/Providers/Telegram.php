<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Telegram implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $providersUrl = config('share-buttons.providers.telegram.url');

        $title = empty($options['title']) ? config('share-buttons.providers.telegram.text') : $options['title'];

        return $providersUrl . '?url=' . $url . '&text=' . urlencode($title);
    }
}
