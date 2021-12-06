<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

class LinkedIn implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $title = empty($options['title']) ? config('laravel-share.services.linkedin.text') : $options['title'];
        $summary = empty($options['summary']) ? '' : $options['summary'];

        $providersUrl = config('laravel-share.services.linkedin.url');
        $mini = config('laravel-share.services.linkedin.extra.mini');

        return $providersUrl . '?mini=' . $mini . '&url=' . $url . '&title=' . urlencode($title) . '&summary=' . urlencode($summary);
    }
}
