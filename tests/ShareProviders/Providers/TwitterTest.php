<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Factory;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TwitterTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = Factory::createInstance('twitter');

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_twitter_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'https://twitter.com/intent/tweet?text=Default+share+text&url=https://mysite.com';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_generate_a_twitter_share_link_with_custom_title()
    {
        $result = $this->provider->buildUrl('https://mysite.com', 'Title', []);
        $expected = 'https://twitter.com/intent/tweet?text=Title&url=https://mysite.com';

        $this->assertEquals($expected, $result);
    }
}
