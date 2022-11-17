<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Telegram;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TelegramTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_generate_a_share_link()
    {
        $provider = Telegram::createFromMethodCall('https://mysite.com', '', []);
        $expected = 'https://telegram.me/share/url?url=https://mysite.com&text=Default+share+text';

        $this->assertEquals($expected, $provider->getUrl());
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $provider = Telegram::createFromMethodCall('https://mysite.com', 'Title', []);
        $expected = 'https://telegram.me/share/url?url=https://mysite.com&text=Title';

        $this->assertEquals($expected, $provider->getUrl());
    }
}
