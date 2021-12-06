<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

interface ShareProvider
{
    public function buildUrl(): string;
}
