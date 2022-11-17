<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\CopyLink;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class CopyLinkTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = CopyLink::create();

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_share_link()
    {
        $provider = CopyLink::createFromMethodCall('https://mysite.com', '', []);
        $expected = 'https://mysite.com';

        $this->assertSame($expected, $provider->getUrl());
    }

    /** @test */
    public function it_can_generate_a_share_link_replaced_with_hash()
    {
        config()->set('share-buttons.providers.copylink.extra.hash', true);

        $provider = CopyLink::createFromMethodCall('https://mysite.com', '', []);
        $expected = '#';

        $this->assertSame($expected, $provider->getUrl());
    }
}
