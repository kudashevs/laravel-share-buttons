<?php

namespace Kudashevs\ShareButtons\Tests\Unit\ValueObjects;

use Kudashevs\ShareButtons\Exceptions\InvalidProcessedCallArgument;
use Kudashevs\ShareButtons\Tests\TestCase;
use Kudashevs\ShareButtons\ValueObjects\ProcessedCall;
use PHPUnit\Framework\Attributes\Test;

class ProcessedCallTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function it_can_throw_an_exception_when_empty_name(): void
    {
        $this->expectException(InvalidProcessedCallArgument::class);
        $this->expectExceptionMessage('empty');

        new ProcessedCall('', $this->generateRequiredArguments());
    }

    #[Test]
    public function it_creates_an_object_with_a_name_only(): void
    {
        $name = 'twitter';
        $arguments = $this->generateRequiredArguments();

        $instance = new ProcessedCall($name, $arguments);

        $this->assertSame($name, $instance->getName());
        $this->assertSame($arguments, $instance->getArguments());
    }

    #[Test]
    public function it_creates_an_object_with_the_provided_state(): void
    {
        $name = 'facebook';
        $arguments = array_merge(['title' => 'test'], $this->generateRequiredArguments());

        $instance = new ProcessedCall($name, $arguments);

        $this->assertSame($name, $instance->getName());
        $this->assertSame($arguments, $instance->getArguments());
    }

    /**
     * @return array{url: string, text: string}
     */
    private function generateRequiredArguments(): array
    {
        return [
            'url' => 'any',
            'text' => 'any',
        ];
    }
}
