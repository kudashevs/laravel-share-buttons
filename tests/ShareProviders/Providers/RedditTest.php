<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Reddit;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class RedditTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = Reddit::create();

        $this->assertEquals('reddit', $provider->getName());
    }

    /** @test */
    public function it_can_retrieve_a_default_text()
    {
        $provider = Reddit::create();

        $this->assertEquals('Default share text', $provider->getText());
    }
}
