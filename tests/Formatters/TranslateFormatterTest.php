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
        $version = config('share-buttons.fontAwesomeVersion');
        $formatter = new TranslateFormatter(['fontAwesomeVersion' => 'wrong']);

        $result = $formatter->getOptions();

        $this->assertArrayHasKey('formatter_version', $result);
        $this->assertSame($version, $result['formatter_version']);
    }

    /** @test */
    public function it_can_setup_block_prefix()
    {
        $formatter = new TranslateFormatter(['block_prefix' => '<div>']);

        $result = $formatter->getOptions();

        $this->assertArrayHasKey('block_prefix', $result);
        $this->assertSame('<div>', $result['block_prefix']);
    }

    /** @test */
    public function it_can_setup_block_suffix()
    {
        $formatter = new TranslateFormatter(['block_suffix' => '</div>']);

        $result = $formatter->getOptions();

        $this->assertArrayHasKey('block_suffix', $result);
        $this->assertSame('</div>', $result['block_suffix']);
    }

    /** @test */
    public function it_can_setup_element_prefix()
    {
        $formatter = new TranslateFormatter(['element_prefix' => '<p>']);

        $result = $formatter->getOptions();

        $this->assertArrayHasKey('element_prefix', $result);
        $this->assertSame('<p>', $result['element_prefix']);
    }

    /** @test */
    public function it_can_setup_element_suffix()
    {
        $formatter = new TranslateFormatter(['element_suffix' => '</p>']);

        $result = $formatter->getOptions();

        $this->assertArrayHasKey('element_suffix', $result);
        $this->assertSame('</p>', $result['element_suffix']);
    }
}
