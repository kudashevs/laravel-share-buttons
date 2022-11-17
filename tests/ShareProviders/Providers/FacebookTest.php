<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Facebook;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class FacebookTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_generate_a_share_link()
    {
        $provider = Facebook::createFromMethodCall('https://mysite.com', '', []);
        $expected = 'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=Default+share+text';

        $this->assertEquals($expected, $provider->getUrl());
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $provider = Facebook::createFromMethodCall('https://mysite.com', 'Title', []);
        $expected = 'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=Title';

        $this->assertEquals($expected, $provider->getUrl());
    }
}
