<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class WhatsApp extends ShareProvider
{
    /**
     * @inheritDoc
     */
    public function buildUrl(string $link, string $title, array $options = []): string
    {
        $shareLink = config('share-buttons.providers.whatsapp.url');

        return $shareLink . '?text=' . $link;
    }
}
