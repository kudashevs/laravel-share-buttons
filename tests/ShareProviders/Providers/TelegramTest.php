<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\Factories\ShareProviderFactory;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TelegramTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = ShareProviderFactory::createFromName('telegram');

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'https://telegram.me/share/url?url=https://mysite.com&text=Default+share+text';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $result = $this->provider->buildUrl('https://mysite.com', 'Title', []);
        $expected = 'https://telegram.me/share/url?url=https://mysite.com&text=Title';

        $this->assertEquals($expected, $result);
    }
}
