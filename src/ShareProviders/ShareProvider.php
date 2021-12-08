<?php

namespace Kudashevs\ShareButtons\ShareProviders;

interface ShareProvider
{
    public function buildUrl(string $url, string $title, array $options): string;
}
