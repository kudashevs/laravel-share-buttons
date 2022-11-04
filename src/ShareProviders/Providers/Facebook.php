<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

final class Facebook extends ShareProvider
{
    protected string $name = 'facebook';

    /**
     * @inheritDoc
     */
    public function buildUrl(string $link, string $title, array $options): string
    {
        $template = $this->retrieveProviderUrl();
        $replacements = $this->prepareReplacements($link, $title, $options);

        return $this->templater->process($template, $replacements);
    }
}
