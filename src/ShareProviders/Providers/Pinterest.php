<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Pinterest extends ShareProvider
{
    /**
     * @inheritDoc
     */
    public function buildUrl(string $link, string $title, array $options = []): string
    {
        $shareLink = config('share-buttons.providers.pinterest.url');

        return $shareLink . '?url=' . $link;
    }
}
