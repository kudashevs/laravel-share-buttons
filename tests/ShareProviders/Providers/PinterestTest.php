<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Pinterest;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class PinterestTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_generate_a_share_link()
    {
        $provider = Pinterest::createFromMethodCall('https://mysite.com', '', []);
        $expected = 'https://pinterest.com/pin/create/button/?url=https://mysite.com';

        $this->assertEquals($expected, $provider->getUrl());
    }
}
