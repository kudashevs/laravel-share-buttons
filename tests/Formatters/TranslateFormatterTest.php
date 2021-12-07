<?php

namespace Kudashevs\ShareButtons\Tests\Formatters;

use Kudashevs\ShareButtons\Formatters\TranslateFormatter;
use PHPUnit\Framework\TestCase;

class TranslateFormatterTest extends TestCase
{
    /** @test */
    public function it_can_setup_font_awesome_version()
    {
        $formatter = new TranslateFormatter(['fontAwesomeVersion' => 3]);

        $result = $formatter->getOptions();

        $this->assertArrayHasKey('formatter_version', $result);
        $this->assertSame(3, $result['formatter_version']);
    }
}
