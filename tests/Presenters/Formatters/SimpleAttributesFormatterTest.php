<?php

namespace Kudashevs\ShareButtons\Tests\Presenters\Formatters;

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
    public function it_can_remove_unknown_attributes()
    {
        $attributes = ['unknown' => 'test'];

        $result = $this->formatter->format($attributes);

        $this->assertArrayNotHasKey('unknown', $result);
    }

    /** @test */
    public function it_can_return_an_empty_string_when_an_attribute_is_not_provided()
    {
        $attributes = [];

        $result = $this->formatter->format($attributes);

        $this->assertSame('', $result['class']);
    }

    /** @test */
    public function it_can_format_known_attributes()
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
