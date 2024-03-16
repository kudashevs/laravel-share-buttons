<?php

namespace Kudashevs\ShareButtons\Tests\Unit\ValueObjects;

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
    public function it_can_throw_an_exception_when_empty_name()
    {
        $this->expectException(InvalidProcessedCallArgument::class);
        $this->expectExceptionMessage('empty');

        new ProcessedCall('', []);
    }

    /** @test */
    public function it_creates_an_object_with_a_name_only()
    {
        $name = 'twitter';

        $instance = new ProcessedCall($name, []);

        $this->assertSame($name, $instance->getName());
        $this->assertEmpty($instance->getArguments());
    }

    /** @test */
    public function it_creates_an_object_with_the_provided_state()
    {
        $name = 'facebook';
        $options = ['title' => 'test'];

        $instance = new ProcessedCall($name, $options);

        $this->assertSame($name, $instance->getName());
        $this->assertSame($options, $instance->getArguments());
    }
}
