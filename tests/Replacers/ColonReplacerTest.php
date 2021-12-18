<?php

namespace Kudashevs\ShareButtons\Tests\Replacers;

use Kudashevs\ShareButtons\Replacers\ColonReplacer;
use PHPUnit\Framework\TestCase;

class ColonReplacerTest extends TestCase
{
    private $replacer;

    protected function setUp(): void
    {
        $this->replacer = new ColonReplacer();
    }

    /** @test */
    public function it_can_replace_a_pattern_with_replacement()
    {
        $expected = 'test that string';
        $input = 'test :this string';
        $replacements = [
            'this' => 'that',
        ];

        $result = $this->replacer->replace($input, $replacements);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function it_can_replace_multiple_patterns_with_multiple_replacements()
    {
        $expected = 'test that simple string';
        $input = 'test :this :complex string';
        $replacements = [
            'this' => 'that',
            'complex' => 'simple',
        ];

        $result = $this->replacer->replace($input, $replacements);

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function it_can_replace_a_pattern_with_replacement_multiple_times()
    {
        $expected = 'test that that string';
        $input = 'test :this :this string';
        $replacements = [
            'this' => 'that',
        ];

        $result = $this->replacer->replace($input, $replacements);

        $this->assertSame($expected, $result);
    }
}
