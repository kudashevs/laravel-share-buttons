<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Factory;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class WhatsAppTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = Factory::createInstance('whatsapp');

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_linkedin_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'https://wa.me/?text=https://mysite.com';

        $this->assertEquals($expected, $result);
    }
}
