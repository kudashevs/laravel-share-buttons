<?php

namespace Kudashevs\ShareButtons\Tests\Unit\Factories;

use Kudashevs\ShareButtons\Exceptions\InvalidTemplaterFactoryArgument;
use Kudashevs\ShareButtons\Factories\TemplaterFactory;
use Kudashevs\ShareButtons\Templaters\LaravelTemplater;
use PHPUnit\Framework\TestCase;

class TemplaterFactoryTest extends TestCase
{
    /** @test */
    public function it_can_throw_an_exception_when_an_unknown_formatter_is_provided(): void
    {
        $this->expectException(InvalidTemplaterFactoryArgument::class);
        $this->expectExceptionMessage('not a valid');

        TemplaterFactory::createFromOptions([
            'templater' => \stdClass::class,
        ]);
    }

    /** @test */
    public function it_can_be_instantiated_from_options(): void
    {
        $formatter = TemplaterFactory::createFromOptions([
            'templater' => LaravelTemplater::class,
        ]);

        $this->assertInstanceOf(LaravelTemplater::class, $formatter);
    }
}
