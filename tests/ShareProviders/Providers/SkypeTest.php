<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\ShareProviderFactory;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class SkypeTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = ShareProviderFactory::createFromName('skype');

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'https://web.skype.com/share?url=https://mysite.com&text=Default+share+text&source=button';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $result = $this->provider->buildUrl('https://mysite.com', 'Title', []);
        $expected = 'https://web.skype.com/share?url=https://mysite.com&text=Title&source=button';

        $this->assertEquals($expected, $result);
    }
}
