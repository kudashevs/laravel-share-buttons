<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders;

use Kudashevs\ShareButtons\ShareProviders\Providers\LinkedIn;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class ShareProviderTest extends ExtendedTestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application
    }

    /** @test */
    public function it_can_create_an_instance()
    {
        $instance = LinkedIn::create();

        $this->assertSame('linkedin', $instance->getName());
    }

    /** @test */
    public function it_can_retrieve_initial_values()
    {
        $instance = LinkedIn::create();

        $this->assertNotEmpty($instance->getText());
        $this->assertNotEmpty($instance->getExtras());
    }

    /** @test */
    public function it_can_retrieve_url_replacements()
    {
        $instance = LinkedIn::create();

        $this->assertNotEmpty($instance->getUrlReplacements());
        $this->assertArrayHasKey('text', $instance->getUrlReplacements());
    }
}
