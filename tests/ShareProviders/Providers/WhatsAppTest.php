<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\WhatsApp;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class WhatsAppTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = WhatsApp::create();

        $this->assertEquals('whatsapp', $provider->getName());
    }

    /** @test */
    public function it_can_retrieve_extras()
    {
        $provider = WhatsApp::create();

        $this->assertArrayHasKey('mini', $provider->getExtras());
    }
}
