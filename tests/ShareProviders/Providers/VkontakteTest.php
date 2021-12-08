<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Vkontakte;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class VkontakteTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = new Vkontakte();

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_twitter_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'https://vk.com/share.php?url=https://mysite.com&title=Default+share+text';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_generate_a_twitter_share_link_with_custom_title()
    {
        $result = $this->provider->buildUrl('https://mysite.com', 'Title', []);
        $expected = 'https://vk.com/share.php?url=https://mysite.com&title=Title';

        $this->assertEquals($expected, $result);
    }
}
