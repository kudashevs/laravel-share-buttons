<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class Telegram extends ShareProvider
{
    public function buildUrl(string $url, string $title, array $options = []): string
    {
        $shareLink = config('share-buttons.providers.telegram.url');

        $text = empty($title) ? config('share-buttons.providers.telegram.text') : $title;

        return $shareLink . '?url=' . $url . '&text=' . urlencode($text);
    }
}
