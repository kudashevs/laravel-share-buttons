<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Facebook implements ShareProvider
{
    public function buildUrl(string $url, array $options = []): string
    {
        $providersUrl = config('share-buttons.providers.facebook.url');

        return $providersUrl . $url;
    }
}
