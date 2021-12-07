<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class WhatsApp implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $providersUrl = config('share-buttons.providers.whatsapp.url');

        return $providersUrl . $url;
    }
}
