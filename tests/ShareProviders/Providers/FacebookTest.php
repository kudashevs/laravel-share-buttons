<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Factory;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class FacebookTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = Factory::createInstance('facebook');

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_facebook_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com';

        $this->assertEquals($expected, $result);
    }
}
