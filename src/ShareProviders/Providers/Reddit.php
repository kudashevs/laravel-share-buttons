<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Reddit extends ShareProvider
{
    /**
     * @inheritDoc
     */
    public function buildUrl(string $link, string $title, array $options = []): string
    {
        $shareLink = config('share-buttons.providers.reddit.url');

        return $shareLink . '?title=' . $this->prepareTitle($title) . '&url=' . $link;
    }
}
