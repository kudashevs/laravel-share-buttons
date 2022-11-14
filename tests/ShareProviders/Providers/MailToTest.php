<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\MailTo;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class MailToTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = MailTo::create();

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'mailto:?subject=Default+share+text&body=https://mysite.com';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $result = $this->provider->buildUrl('https://mysite.com', 'Title', []);
        $expected = 'mailto:?subject=Title&body=https://mysite.com';

        $this->assertEquals($expected, $result);
    }
}
