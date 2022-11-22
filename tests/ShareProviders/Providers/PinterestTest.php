<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Pinterest;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class PinterestTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = Pinterest::create();

        $this->assertEquals('pinterest', $provider->getName());
    }
}
