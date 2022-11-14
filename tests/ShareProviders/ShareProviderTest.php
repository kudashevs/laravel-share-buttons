<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders;

use Kudashevs\ShareButtons\ShareProviders\Providers\Facebook;
use PHPUnit\Framework\TestCase;

class ShareProviderTest extends TestCase
{
    /** @test */
    public function it_can_create_an_instance()
    {
        $instance = Facebook::create();

        $this->assertNotEmpty($instance->getName());
        $this->assertNotEmpty($instance->getUrl());
        $this->assertIsArray($instance->getOptions());
    }
}
