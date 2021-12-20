<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class LinkedIn extends ShareProvider
{
    /**
     * @inheritDoc
     */
    public function buildUrl(string $link, string $title, array $options = []): string
    {
        $shareLink = config('share-buttons.providers.linkedin.url');
        $mini = config('share-buttons.providers.linkedin.extra.mini');

        $summary = empty($options['summary']) ? '' : $options['summary'];

        return $shareLink . '?mini=' . $mini . '&url=' . $link . '&title=' . $this->prepareTitle($title) . '&summary=' . urlencode($summary);
    }
}
