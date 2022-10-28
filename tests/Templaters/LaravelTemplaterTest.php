<?php

namespace Kudashevs\ShareButtons\Tests\Templaters;

use Kudashevs\ShareButtons\Templaters\LaravelTemplater;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class LaravelTemplaterTest extends ExtendedTestCase
{
    private $replacer;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application

        $this->replacer = new LaravelTemplater();
    }

    /**
     * @test
     * @dataProvider provideDifferentSearchReplaceValues
     */
    public function it_can_perform_a_pattern_replacement(string $input, array $replacements, string $expected)
    {
        $result = $this->replacer->process($input, $replacements);

        $this->assertSame($expected, $result);
    }

    public function provideDifferentSearchReplaceValues()
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
            'replace a pattern in lower case' => [
                'a :test string',
                [
                    'test' => 'tested',
                ],
                'a tested string',
            ],
            'replace a pattern in upper case' => [
                'a :TEST string',
                [
                    'test' => 'tested',
                ],
                'a TESTED string',
            ],
            'does not replace a pattern in mix case' => [
                'a :TeST string',
                [
                    'test' => 'tested',
                ],
                'a :TeST string',
            ],
        ];
    }
}
