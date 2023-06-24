<?php

namespace Kudashevs\ShareButtons\Tests\Unit\Presenters\Formatters;

use Kudashevs\ShareButtons\Presenters\Formatters\SimpleAttributesFormatter;
use PHPUnit\Framework\TestCase;

class SimpleAttributesFormatterTest extends TestCase
{
    private SimpleAttributesFormatter $formatter;

    protected function setUp(): void
    {
        $this->formatter = new SimpleAttributesFormatter();
    }

    /** @test */
    public function it_skips_an_unknown_attribute()
    {
        $attributes = ['unknown' => 'test'];

        $result = $this->formatter->format($attributes);

        $this->assertArrayNotHasKey('unknown', $result);
    }

    /** @test */
    public function it_returns_an_empty_string_when_no_attribute_provided()
    {
        $attributes = [];

        $result = $this->formatter->format($attributes);

        $this->assertSame('', $result['class']);
    }

    /** @test */
    public function it_performs_formatting_of_supported_attributes()
    {
        $attributes = [
            'class' => 'class',
            'id' => 'id',
            'title' => 'title',
            'rel' => 'rel',
        ];

        $expected = [
            'class' => ' class',
            'id' => ' id="id"',
            'title' => ' title="title"',
            'rel' => ' rel="rel"',
        ];

        $result = $this->formatter->format($attributes);

        $this->assertSame($expected, $result);
    }
}
