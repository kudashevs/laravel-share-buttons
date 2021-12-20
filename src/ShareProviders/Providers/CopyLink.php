<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class CopyLink extends ShareProvider
{
    /**
     * @inheritDoc
     */
    public function buildUrl(string $link, string $title, array $options): string
    {
        $shareLink = (config('share-buttons.providers.copylink.extra.hash') === true)
            ? '#'
            : $link;

        return $shareLink;
    }
}
