<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

class Facebook implements ShareProvider
{
    public function buildUrl(): string
    {
        return 'facebook';
    }
}
