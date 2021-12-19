<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders;

use Kudashevs\ShareButtons\Exceptions\InvalidShareProviderNameException;
use Kudashevs\ShareButtons\ShareProviders\Factory;
use Kudashevs\ShareButtons\ShareProviders\Providers\Facebook;
use Kudashevs\ShareButtons\ShareProviders\ShareProvider;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    /** @test */
    public function it_can_throw_exception_on_wrong_provider_name()
    {
        $this->expectException(InvalidShareProviderNameException::class);
        $this->expectExceptionMessage('wrong');

        Factory::createInstance('wrong');
    }

    /** @test */
    public function it_can_return_a_specific_instance_by_name()
    {
        $provider = Factory::createInstance('facebook');

        $this->assertInstanceOf(Facebook::class, $provider);
    }

    /** @test */
    public function it_can_return_all_the_registered_providers()
    {
        $providers = Factory::create();

        $this->assertCount(count(Factory::getProviders()), $providers);
        $this->assertArrayHasKey($this->getProvidersFirstKey(), $providers);
    }

    /** @test */
    public function it_can_return_all_the_registered_providers_in_the_instantiated_state()
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
