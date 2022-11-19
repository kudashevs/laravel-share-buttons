<?php

namespace Kudashevs\ShareButtons\Tests\ValueObjects;

use Kudashevs\ShareButtons\Exceptions\InvalidProcessedCallArgument;
use Kudashevs\ShareButtons\ShareProviders\Providers\Facebook;
use Kudashevs\ShareButtons\ShareProviders\ShareProvider;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;
use Kudashevs\ShareButtons\ValueObjects\ProcessedCall;

class ProcessedCallTest extends ExtendedTestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application
    }

    /** @test */
    public function it_can_throw_exception_when_empty_name()
    {
        $this->expectException(InvalidProcessedCallArgument::class);
        $this->expectExceptionMessage('empty');

        $providerStub = $this->createStub(ShareProvider::class);
        new ProcessedCall('', $providerStub, []);
    }

    /** @test */
    public function it_creates_object_with_the_correct_state()
    {
        $name = 'facebook';
        $provider = Facebook::create();
        $options = ['title' => 'test'];

        $instance = new ProcessedCall($name, $provider, $options);

        $this->assertSame($name, $instance->getName());
        $this->assertSame($provider, $instance->getProvider());
        $this->assertSame($options, $instance->getArguments());
    }
}
