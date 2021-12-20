<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

class CopyLink extends ShareProvider
{
    /**
     * @inheritDoc
     */
    public function buildUrl(string $link, string $title, array $options): string
    {
        $link = $this->prepareLink($link);

        $template = $this->retrieveProviderUrl();
        $replacements = $this->prepareReplacements($link, $title, $options);

        return $this->templater->process($template, $replacements);
    }

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
