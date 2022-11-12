<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

final class Telegram extends ShareProvider
{
    protected string $name = 'telegram';

    /**
     * @inheritDoc
     */
    public function buildUrl(string $link, string $title, array $options): string
    {
        $template = $this->retrieveProviderUrl();
        $replacements = $this->retrieveReplacements($link, $title, $options);

        return $this->templater->process($template, $replacements);
    }
}
