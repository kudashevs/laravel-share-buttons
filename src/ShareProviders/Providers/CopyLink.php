<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

final class CopyLink extends ShareProvider
{
    protected string $name = 'copylink';

    /**
     * @param string $link
     * @return string
     */
    private function prepareLink(string $link)
    {
        return (config('share-buttons.providers.' . $this->name . '.extra.hash') === true)
            ? '#'
            : $link;
    }
}
