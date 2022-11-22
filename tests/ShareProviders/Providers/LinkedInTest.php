<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\LinkedIn;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class LinkedInTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = LinkedIn::create();

        $this->assertEquals('linkedin', $provider->getName());
    }

    /** @test */
    public function it_can_retrieve_a_default_text()
    {
        $provider = LinkedIn::create();

        $this->assertEquals('Default share text', $provider->getText());
    }

    /** @test */
    public function it_can_retrieve_extras()
    {
        $provider = LinkedIn::create();

        $this->assertArrayHasKey('mini', $provider->getExtras());
        $this->assertArrayHasKey('summary', $provider->getExtras());
    }
}
