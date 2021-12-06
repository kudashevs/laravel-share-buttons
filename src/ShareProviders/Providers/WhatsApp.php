<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

class WhatsApp implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $providersUrl = config('laravel-share.services.whatsapp.url');

        return $providersUrl . $url;
    }
}
