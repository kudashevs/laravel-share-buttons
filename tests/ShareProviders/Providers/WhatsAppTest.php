<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\WhatsApp;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class WhatsAppTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = WhatsApp::create();

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_share_link()
    {
        $provider = WhatsApp::createFromMethodCall('https://mysite.com', '', []);
        $expected = 'https://wa.me/?text=https://mysite.com';

        $this->assertEquals($expected, $provider->getUrl());
    }
}
