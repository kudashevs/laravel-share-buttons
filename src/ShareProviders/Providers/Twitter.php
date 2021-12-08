<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Twitter implements ShareProvider
{

    public function buildUrl(string $url, string $title, array $options = []): string
    {
        $shareLink = config('share-buttons.providers.twitter.url');

        $text = empty($title) ? config('share-buttons.providers.twitter.text') : $title;

        return $shareLink . '?text=' . urlencode($text) . '&url=' . $url;
    }
}
