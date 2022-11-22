<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Skype;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class SkypeTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = Skype::create();

        $this->assertEquals('skype', $provider->getName());
    }

    /** @test */
    public function it_can_retrieve_a_default_text()
    {
        $provider = Skype::create();

        $this->assertEquals('Default share text', $provider->getText());
    }
}
