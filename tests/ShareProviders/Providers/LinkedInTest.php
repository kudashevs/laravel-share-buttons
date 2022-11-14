<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\LinkedIn;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class LinkedInTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = LinkedIn::create();

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=Default+share+text&summary=';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $result = $this->provider->buildUrl('https://mysite.com', 'Title', []);
        $expected = 'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=Title&summary=';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_generate_a_share_link_with_summary()
    {
        $result = $this->provider->buildUrl('https://mysite.com', 'Title',
            ['summary' => 'A summary can be passed here']);
        $expected = 'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=Title&summary=A+summary+can+be+passed+here';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_generate_a_share_link_without_summary()
    {
        $result = $this->provider->buildUrl('https://mysite.com', 'Title', []);
        $expected = 'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=Title&summary=';

        $this->assertEquals($expected, $result);
    }
}
