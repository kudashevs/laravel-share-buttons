<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProviderFactory;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class WhatsAppTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = ShareProviderFactory::createFromName('whatsapp');

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'https://wa.me/?text=https://mysite.com';

        $this->assertEquals($expected, $result);
    }
}
