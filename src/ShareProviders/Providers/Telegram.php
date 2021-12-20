<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Telegram extends ShareProvider
{
    /**
     * @inheritDoc
     */
    public function buildUrl(string $link, string $title, array $options = []): string
    {
        $shareLink = config('share-buttons.providers.telegram.url');

        return $shareLink . '?url=' . $link . '&text=' . $this->prepareTitle($title);
    }
}
