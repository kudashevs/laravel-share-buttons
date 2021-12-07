<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Pinterest implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $repository = config('share-buttons.providers.pinterest.url');

        return $repository . $url;
    }
}
