<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Twitter extends ShareProvider
{
    /**
     * @inheritDoc
     */
    public function buildUrl(string $url, string $title, array $options = []): string
    {
        $shareLink = config('share-buttons.providers.twitter.url');

        return $shareLink . '?text=' . $this->prepareTitle($title) . '&url=' . $url;
    }
}
