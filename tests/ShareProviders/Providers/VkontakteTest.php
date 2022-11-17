<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Vkontakte;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class VkontakteTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_generate_a_share_link()
    {
        $provider = Vkontakte::createFromMethodCall('https://mysite.com', '', []);
        $expected = 'https://vk.com/share.php?url=https://mysite.com&title=Default+share+text';

        $this->assertEquals($expected, $provider->getUrl());
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $provider = Vkontakte::createFromMethodCall('https://mysite.com', 'Title', []);
        $expected = 'https://vk.com/share.php?url=https://mysite.com&title=Title';

        $this->assertEquals($expected, $provider->getUrl());
    }
}
