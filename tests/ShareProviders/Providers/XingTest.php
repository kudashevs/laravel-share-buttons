<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders\Providers;

use Kudashevs\ShareButtons\ShareProviders\Providers\Xing;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class XingTest extends ExtendedTestCase
{
    private $provider;

    protected function setUp(): void
    {
        $this->provider = Xing::create();

        parent::setUp();
    }

    /** @test */
    public function it_can_generate_a_share_link()
    {
        $result = $this->provider->buildUrl('https://mysite.com', '', []);
        $expected = 'https://www.xing.com/spi/shares/new?url=https://mysite.com';

        $this->assertEquals($expected, $result);
    }
}
