<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProviderFactory;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class HackerNewsTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = ShareProviderFactory::createInstance('hackernews');

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'https://news.ycombinator.com/submitlink?t=Default+share+text&u=https://mysite.com';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $result = $this->provider->buildUrl('https://mysite.com', 'Title', []);
        $expected = 'https://news.ycombinator.com/submitlink?t=Title&u=https://mysite.com';

        $this->assertEquals($expected, $result);
    }
}
