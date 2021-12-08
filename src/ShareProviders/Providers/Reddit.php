<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Reddit implements ShareProvider
{

    public function buildUrl(string $url, string $title, array $options = []): string
    {
        $shareLink = config('share-buttons.providers.reddit.url');

        $text = empty($title) ? config('share-buttons.providers.reddit.text') : $title;

        return $shareLink . '?title=' . urlencode($text) . '&url=' . $url;
    }
}
