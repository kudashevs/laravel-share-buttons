<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Reddit implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $shareLink = config('share-buttons.providers.reddit.url');

        $title = empty($options['title']) ? config('share-buttons.providers.reddit.text') : $options['title'];

        return $shareLink . '?title=' . urlencode($title) . '&url=' . $url;
    }
}
