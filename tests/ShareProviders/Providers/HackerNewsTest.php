<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\HackerNews;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class HackerNewsTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = HackerNews::create();

        $this->assertEquals('hackernews', $provider->getName());
    }

    /** @test */
    public function it_can_retrieve_a_default_text()
    {
        $provider = HackerNews::create();

        $this->assertEquals('Default share text', $provider->getText());
    }
}
