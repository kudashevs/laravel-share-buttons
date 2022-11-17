<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\LinkedIn;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class LinkedInTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_generate_a_share_link()
    {
        $provider = LinkedIn::createFromMethodCall('https://mysite.com', '', []);
        $expected = 'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=Default+share+text&summary=';

        $this->assertEquals($expected, $provider->getUrl());
    }

    /** @test */
    public function it_can_generate_a_share_link_with_custom_title()
    {
        $provider = LinkedIn::createFromMethodCall('https://mysite.com', 'Title', []);
        $expected = 'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=Title&summary=';

        $this->assertEquals($expected, $provider->getUrl());
    }

    /** @test */
    public function it_can_generate_a_share_link_with_summary()
    {
        $provider = LinkedIn::createFromMethodCall('https://mysite.com', 'Title', ['summary' => 'A summary']);
        $expected = 'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=Title&summary=A+summary';

        $this->assertEquals($expected, $provider->getUrl());
    }

    /** @test */
    public function it_can_generate_a_share_link_without_summary()
    {
        $provider = LinkedIn::createFromMethodCall('https://mysite.com', 'Title', []);
        $expected = 'https://www.linkedin.com/sharing/share-offsite?mini=true&url=https://mysite.com&title=Title&summary=';

        $this->assertEquals($expected, $provider->getUrl());
    }
}
