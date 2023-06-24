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
    public function it_formats_some_of_the_attributes()
    {
        $attributes = [
            'class' => 'active',
            'rel' => 'follow',
        ];

        $expected = [
            'class' => ' active',
            'id' => '',
            'title' => '',
            'rel' => ' rel="follow"',
        ];

        $result = $this->formatter->format($attributes);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function it_formats_all_of_the_attributes()
    {
        $attributes = [
            'class' => 'active',
            'id' => 'id',
            'title' => 'Some title',
            'rel' => 'nofollow',
        ];

        $expected = [
            'class' => ' active',
            'id' => ' id="id"',
            'title' => ' title="Some title"',
            'rel' => ' rel="nofollow"',
        ];

        $result = $this->formatter->format($attributes);

        $this->assertSame($expected, $result);
    }
}
