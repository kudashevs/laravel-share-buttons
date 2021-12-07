<?php

namespace Kudashevs\ShareButtons\Tests\Formatters;

use Kudashevs\ShareButtons\Formatters\TranslateFormatter;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TranslateFormatterTest extends ExtendedTestCase
{
    /** @test */
    public function it_can_setup_font_awesome_version()
    {
        $formatter = new TranslateFormatter(['fontAwesomeVersion' => 3]);

        $result = $formatter->getOptions();

        $this->assertArrayHasKey('formatter_version', $result);
        $this->assertSame(3, $result['formatter_version']);
    }

    /** @test */
    public function it_can_return_default_font_awesome_version_on_empty_option()
    {
        $formatter = new TranslateFormatter(['fontAwesomeVersion' => 'wrong']);

        $result = $formatter->getOptions();

        $this->assertArrayHasKey('formatter_version', $result);
        $this->assertSame(5, $result['formatter_version']);
    }
}
