<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders;

use Kudashevs\ShareButtons\ShareProviders\Providers\Facebook;
use PHPUnit\Framework\TestCase;

class ShareProviderTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $instance = new Facebook();

        $this->assertNotEmpty($instance->getName());
    }
}
