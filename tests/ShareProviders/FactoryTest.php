<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders;

use Kudashevs\ShareButtons\ShareProviders\Factory;
use Kudashevs\ShareButtons\ShareProviders\ShareProvider;
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

        $this->assertCount(count(Factory::getProviders()), $providers);
        $this->assertArrayHasKey($this->getProvidersFirstKey(), $providers);
    }

    /** @test */
    public function it_returns_an_array_with_specific_instances()
    {
        $providers = Factory::create();
        $firstKey = $this->getProvidersFirstKey();

        $this->assertIsObject($providers[$firstKey]);
        $this->assertInstanceOf(ShareProvider::class, $providers[$firstKey]);
    }

    private function getProvidersFirstKey()
    {
        return current(array_keys(Factory::getProviders()));
    }
}
