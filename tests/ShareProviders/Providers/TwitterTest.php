<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Twitter;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TwitterTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = Twitter::create();

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_share_link()
    {
        $result = Twitter::createFromMethodCall('https://mysite.com', '', []);
        $expected = 'https://twitter.com/intent/tweet?text=Default+share+text&url=https://mysite.com';

        $this->assertEquals($expected, $result->getUrl());
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $result = Twitter::createFromMethodCall('https://mysite.com', 'Title', []);
        $expected = 'https://twitter.com/intent/tweet?text=Title&url=https://mysite.com';

        $this->assertEquals($expected, $result->getUrl());
    }
}
