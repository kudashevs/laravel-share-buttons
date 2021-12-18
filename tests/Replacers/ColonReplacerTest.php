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

    /**
     * @test
     * @dataProvider provide_different_patterns_and_matches_for_replacement
     * @param string $input
     * @param array $replacements
     * @param string $expected
     */
    public function it_can_perform_a_pattern_replacement(string $input, array $replacements, string $expected)
    {
        $result = $this->replacer->replace($input, $replacements);

        $this->assertSame($expected, $result);
    }

    public function provide_different_patterns_and_matches_for_replacement()
    {
        return [
            'replace a pattern with the replacement' => [
                'test :this string',
                [
                    'this' => 'that',
                ],
                'test that string',
            ],
            'replace multiple patterns with multiple replacements' => [
                'test :this :complex string',
                [
                    'this' => 'that',
                    'complex' => 'simple',
                ],
                'test that simple string',
            ],
            'replace a pattern with the replacement multiple times' => [
                'test :this :this string',
                [
                    'this' => 'that',
                ],
                'test that that string',
            ],
        ];
    }
}
