<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders;

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

    /** @test */
    public function it_returns_an_array_with_specific_providers()
    {
        $providers = Factory::create();
        $firstKey = current(array_keys(Factory::$providers));

        $this->assertCount(count(Factory::$providers), $providers);
        $this->assertArrayHasKey($firstKey, $providers);
    }
}
