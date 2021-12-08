<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Facebook extends ShareProvider
{
    /**
     * @inheritDoc
     */
    public function buildUrl(string $url, string $title, array $options = []): string
    {
        $shareLink = config('share-buttons.providers.facebook.url');

        return $shareLink . $url;
    }
}
