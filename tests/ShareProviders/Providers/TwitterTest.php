<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Twitter;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TwitterTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = Twitter::create();

        $this->assertEquals('twitter', $provider->getName());
    }

    /** @test */
    public function it_can_retrieve_a_default_text()
    {
        $provider = Twitter::create();

        $this->assertEquals('Default share text', $provider->getText());;
    }
}
