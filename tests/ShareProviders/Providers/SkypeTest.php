<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Skype;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class SkypeTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_generate_a_share_link()
    {
        $provider = Skype::createFromMethodCall('https://mysite.com', '', []);
        $expected = 'https://web.skype.com/share?url=https://mysite.com&text=Default+share+text&source=button';

        $this->assertEquals($expected, $provider->getUrl());
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $provider = Skype::createFromMethodCall('https://mysite.com', 'Title', []);
        $expected = 'https://web.skype.com/share?url=https://mysite.com&text=Title&source=button';

        $this->assertEquals($expected, $provider->getUrl());
    }
}
