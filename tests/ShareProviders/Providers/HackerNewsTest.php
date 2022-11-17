<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\HackerNews;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class HackerNewsTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_generate_a_share_link()
    {
        $provider = HackerNews::createFromMethodCall('https://mysite.com', '', []);
        $expected = 'https://news.ycombinator.com/submitlink?t=Default+share+text&u=https://mysite.com';

        $this->assertEquals($expected, $provider->getUrl());
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $provider = HackerNews::createFromMethodCall('https://mysite.com', 'Title', []);
        $expected = 'https://news.ycombinator.com/submitlink?t=Title&u=https://mysite.com';

        $this->assertEquals($expected, $provider->getUrl());
    }
}
