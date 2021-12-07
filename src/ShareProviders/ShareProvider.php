<?php

namespace Kudashevs\ShareButtons\ShareProviders;

interface ShareProvider
{
    public function buildUrl(string $url, array $options): string;
}
