<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Facebook;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class FacebookTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = Facebook::create();

        $this->assertEquals('facebook', $provider->getName());
    }

    /** @test */
    public function it_can_retrieve_a_default_text()
    {
        $provider = Facebook::create();

        $this->assertEquals('Default share text', $provider->getText());
    }
}
