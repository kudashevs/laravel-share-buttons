<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Factory;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class CopyLinkTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = Factory::createInstance('copylink');

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_copylink_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'https://mysite.com';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_generate_a_copylink_share_link_replaced_with_hash()
    {
        config()->set('share-buttons.providers.copylink.extra.hash', true);

        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = '#';

        $this->assertEquals($expected, $result);
    }
}
