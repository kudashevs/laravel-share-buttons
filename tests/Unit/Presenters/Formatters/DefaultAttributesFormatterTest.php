<?php

namespace Kudashevs\ShareButtons\Tests\Unit\Presenters\Formatters;

use Kudashevs\ShareButtons\Presenters\Formatters\DefaultAttributesFormatter;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DefaultAttributesFormatterTest extends TestCase
{
    private DefaultAttributesFormatter $formatter;

    protected function setUp(): void
    {
        $this->formatter = new DefaultAttributesFormatter();
    }

    #[Test]
    public function it_skips_an_unknown_attribute(): void
    {
        $attributes = ['unknown' => 'test'];

        $result = $this->formatter->format($attributes);

        $this->assertArrayNotHasKey('unknown', $result);
    }

    #[Test]
    public function it_returns_an_empty_string_when_no_attribute_provided(): void
    {
        $attributes = [];

        $result = $this->formatter->format($attributes);

        $this->assertSame('', $result['class']);
    }

    #[Test]
    public function it_formats_some_of_the_attributes(): void
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

    #[Test]
    public function it_formats_all_of_the_attributes(): void
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
