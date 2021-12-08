<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Pinterest extends ShareProvider
{
    public function buildUrl(string $url, string $title, array $options = []): string
    {
        $shareLink = config('share-buttons.providers.pinterest.url');

        return $shareLink . $url;
    }
}
