<?php

namespace Kudashevs\ShareButtons\Tests\Templaters;

use Kudashevs\ShareButtons\Templaters\LaravelTemplater;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class LaravelTemplaterTest extends ExtendedTestCase
{
    private $templater;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application

        $this->templater = new LaravelTemplater();
    }

    /**
     * @test
     * @dataProvider provideDifferentSearchReplaceValues
     */
    public function it_can_perform_a_pattern_replacement(string $input, array $replacements, string $expected)
    {
        $result = $this->templater->process($input, $replacements);

        $this->assertSame($expected, $result);
    }

    public function provideDifferentSearchReplaceValues()
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
