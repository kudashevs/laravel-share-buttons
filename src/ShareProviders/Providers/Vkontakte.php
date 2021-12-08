<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Vkontakte extends ShareProvider
{
    /**
     * @inheritDoc
     */
    public function buildUrl(string $url, string $title, array $options): string
    {
        $shareLink = config('share-buttons.providers.vkontakte.url');

        return $shareLink . $url . '&title=' . $this->prepareTitle($title);
    }
}
