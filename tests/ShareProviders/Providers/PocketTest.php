<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Pocket;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class PocketTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = Pocket::create();

        $this->assertEquals('pocket', $provider->getName());
    }

    /** @test */
    public function it_can_retrieve_a_default_text()
    {
        $provider = Pocket::create();

        $this->assertEquals('Default share text', $provider->getText());
    }
}
