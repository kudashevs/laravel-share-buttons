<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\CopyLink;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class CopyLinkTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_be_created()
    {
        $provider = CopyLink::create();

        $this->assertSame('copylink', $provider->getName());
    }

    /** @test */
    public function it_can_generate_a_link_replaced_with_hash()
    {
        config()->set('share-buttons.providers.copylink.extra.hash', true);

        $provider = CopyLink::create();
        $expected = '#';

        $this->assertSame($expected, $provider->getUrl());
    }
}
