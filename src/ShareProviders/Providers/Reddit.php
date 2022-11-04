<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

final class Reddit extends ShareProvider
{
    protected string $name = 'reddit';

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
