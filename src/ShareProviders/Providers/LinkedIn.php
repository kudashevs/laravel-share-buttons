<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class LinkedIn implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $shareLink = config('share-buttons.providers.linkedin.url');

        $title = empty($options['title']) ? config('share-buttons.providers.linkedin.text') : $options['title'];
        $summary = empty($options['summary']) ? '' : $options['summary'];
        $mini = config('share-buttons.providers.linkedin.extra.mini');

        return $shareLink . '?mini=' . $mini . '&url=' . $url . '&title=' . urlencode($title) . '&summary=' . urlencode($summary);
    }
}
