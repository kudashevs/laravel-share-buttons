<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class LinkedIn implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $title = empty($options['title']) ? config('share-buttons.providers.linkedin.text') : $options['title'];
        $summary = empty($options['summary']) ? '' : $options['summary'];

        $providersUrl = config('share-buttons.providers.linkedin.url');
        $mini = config('share-buttons.providers.linkedin.extra.mini');

        return $providersUrl . '?mini=' . $mini . '&url=' . $url . '&title=' . urlencode($title) . '&summary=' . urlencode($summary);
    }
}
