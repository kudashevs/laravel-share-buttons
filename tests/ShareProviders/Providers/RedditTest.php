<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Reddit;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class RedditTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = new Reddit();

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_reddit_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'https://www.reddit.com/submit?title=Default+share+text&url=https://mysite.com';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_generate_a_reddit_with_custom_title()
    {
        $result = $this->provider->buildUrl('https://mysite.com', 'Title', []);
        $expected = 'https://www.reddit.com/submit?title=Title&url=https://mysite.com';

        $this->assertEquals($expected, $result);
    }
}
