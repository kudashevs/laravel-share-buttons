<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Vkontakte extends ShareProvider
{
    /**
     * @inheritDoc
     */
    public function buildUrl(string $link, string $title, array $options): string
    {
        $shareLink = config('share-buttons.providers.vkontakte.url');

        return $shareLink . '?url=' . $link . '&title=' . $this->prepareTitle($title);
    }
}
