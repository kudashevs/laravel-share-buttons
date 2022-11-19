<?php

namespace Kudashevs\ShareButtons\Tests\ValueObjects;

use Kudashevs\ShareButtons\Exceptions\InvalidProcessedCallArgument;
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

        new ProcessedCall('', []);
    }

    /** @test */
    public function it_creates_object_with_the_correct_state()
    {
        $provider = 'facebook';
        $options = ['title' => 'test'];

        $instance = new ProcessedCall($provider, $options);

        $this->assertSame($provider, $instance->getName());
        $this->assertSame($options, $instance->getArguments());
    }
}
