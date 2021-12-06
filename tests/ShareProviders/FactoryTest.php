<?php

namespace Kudashevs\ShareButtons\Test\ShareButtons\ShareProviders;

use Kudashevs\ShareButtons\ShareProviders\Factory;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    /** @test */
    public function it_returns_an_array()
    {
        $providers = Factory::create();

        $this->assertIsArray($providers);
    }
}
