<?php

namespace Kudashevs\ShareButtons\Tests\Unit\Templaters;

use Kudashevs\ShareButtons\Templaters\SimpleColonTemplater;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SimpleColonTemplaterTest extends TestCase
{
    private SimpleColonTemplater $templater;

    protected function setUp(): void
    {
        parent::setUp();

        $this->templater = new SimpleColonTemplater();
    }

    #[Test]
    #[DataProvider('provideDifferentSearchReplaceValues')]
    public function it_performs_a_pattern_replacement(string $input, array $replacements, string $expected): void
    {
        $processedString = $this->templater->process($input, $replacements);

        $this->assertSame($expected, $processedString);
    }

    public static function provideDifferentSearchReplaceValues(): array
    {
        return [
            'replace a search with the replacement' => [
                'test :this string',
                [
                    'this' => 'that',
                ],
                'test that string',
            ],
            'replace multiple searches with multiple replacements' => [
                'test :this :complex string',
                [
                    'this' => 'that',
                    'complex' => 'simple',
                ],
                'test that simple string',
            ],
            'replace a search with the replacement multiple times' => [
                'test :this :this string',
                [
                    'this' => 'that',
                ],
                'test that that string',
            ],
            'replace a search in lowercase letters letters with the replacement' => [
                'a :test string',
                [
                    'test' => 'tested',
                ],
                'a tested string',
            ],
            'replace a search in uppercase letters with the replacement' => [
                'a :TEST string',
                [
                    'test' => 'tested',
                ],
                'a TESTED string',
            ],
            'does not replace a search in mixed letters' => [
                'a :TeST string',
                [
                    'test' => 'tested',
                ],
                'a :TeST string',
            ],
        ];
    }
}
