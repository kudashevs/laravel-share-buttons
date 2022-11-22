<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Xing;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class XingTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = Xing::create();

        $this->assertEquals('xing', $provider->getName());
    }
}
