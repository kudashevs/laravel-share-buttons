<?php

namespace Kudashevs\ShareButtons\Tests\Formatters;

use Kudashevs\ShareButtons\Formatters\TranslateFormatter;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TranslateFormatterTest extends ExtendedTestCase
{
    /**
     * @var TranslateFormatter
     */
    private $formatter;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to initialize a container

        $this->formatter = new TranslateFormatter();
    }

    /** @test */
    public function it_can_setup_font_awesome_version()
    {
        $this->formatter->updateOptions(['fontAwesomeVersion' => 3]);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('formatter_version', $result);
        $this->assertSame(3, $result['formatter_version']);
    }

    /** @test */
    public function it_returns_default_font_awesome_version_on_nonset_option()
    {
        $version = config('share-buttons.fontAwesomeVersion');

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('formatter_version', $result);
        $this->assertSame($version, $result['formatter_version']);
    }

    /** @test */
    public function it_returns_default_font_awesome_version_on_wrong_option()
    {
        $version = config('share-buttons.fontAwesomeVersion');
        $this->formatter->updateOptions(['fontAwesomeVersion' => 'wrong']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('formatter_version', $result);
        $this->assertSame($version, $result['formatter_version']);
    }

    /** @test */
    public function it_can_setup_prefix() // backward compatibility
    {
        $this->formatter->updateOptions(['prefix' => '<div>']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('block_prefix', $result);
        $this->assertSame('<div>', $result['block_prefix']);
    }

    /** @test */
    public function it_can_setup_block_prefix()
    {
        $this->formatter->updateOptions(['block_prefix' => '<div>']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('block_prefix', $result);
        $this->assertSame('<div>', $result['block_prefix']);
    }

    /** @test */
    public function it_returns_default_block_prefix_on_nonset_option()
    {
        $default = config('share-buttons.block_prefix');

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('block_prefix', $result);
        $this->assertSame($default, $result['block_prefix']);
    }

    /** @test */
    public function it_returns_empty_block_prefix_on_empty_option()
    {
        $this->formatter->updateOptions(['block_prefix' => '']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('block_prefix', $result);
        $this->assertSame('', $result['block_prefix']);
    }

    /** @test */
    public function it_can_setup_suffix() // backward compatibility
    {
        $this->formatter->updateOptions(['suffix' => '</div>']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('block_suffix', $result);
        $this->assertSame('</div>', $result['block_suffix']);
    }

    /** @test */
    public function it_can_setup_block_suffix()
    {
        $this->formatter->updateOptions(['block_suffix' => '</div>']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('block_suffix', $result);
        $this->assertSame('</div>', $result['block_suffix']);
    }

    /** @test */
    public function it_returns_default_block_suffix_on_nonset_option()
    {
        $default = config('share-buttons.block_suffix');

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('block_suffix', $result);
        $this->assertSame($default, $result['block_suffix']);
    }

    /** @test */
    public function it_returns_empty_block_suffix_on_empty_option()
    {
        $this->formatter->updateOptions(['block_suffix' => '']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('block_suffix', $result);
        $this->assertSame('', $result['block_suffix']);
    }

    /** @test */
    public function it_can_setup_element_prefix()
    {
        $this->formatter->updateOptions(['element_prefix' => '<p>']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('element_prefix', $result);
        $this->assertSame('<p>', $result['element_prefix']);
    }

    /** @test */
    public function it_returns_default_element_prefix_on_nonset_option()
    {
        $default = config('share-buttons.element_prefix');

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('element_prefix', $result);
        $this->assertSame($default, $result['element_prefix']);
    }

    /** @test */
    public function it_returns_empty_element_prefix_on_empty_option()
    {
        $this->formatter->updateOptions(['element_prefix' => '']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('element_prefix', $result);
        $this->assertSame('', $result['element_prefix']);
    }

    /** @test */
    public function it_can_setup_element_suffix()
    {
        $this->formatter->updateOptions(['element_suffix' => '</p>']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('element_suffix', $result);
        $this->assertSame('</p>', $result['element_suffix']);
    }

    /** @test */
    public function it_returns_default_element_suffix_on_nonset_option()
    {
        $default = config('share-buttons.element_suffix');

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('element_suffix', $result);
        $this->assertSame($default, $result['element_suffix']);
    }

    /** @test */
    public function it_returns_empty_element_suffix_on_empty_option()
    {
        $this->formatter->updateOptions(['element_suffix' => '']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('element_suffix', $result);
        $this->assertSame('', $result['element_suffix']);
    }

    /** @test */
    public function it_can_format_an_element_with_default_styling()
    {
        $expected = '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button"><span class="fab fa-facebook-square"></span></a></li>';

        $result = $this->formatter->formatElement('facebook',
            'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com', []);

        $this->assertNotEmpty($result);
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_format_an_element_with_custom_styling_from_formatter_options()
    {
        $this->formatter->updateOptions(['element_prefix' => '<p>', 'element_suffix' => '</p>']);

        $expected = '<p><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button"><span class="fab fa-facebook-square"></span></a></p>';

        $result = $this->formatter->formatElement('facebook',
            'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com', []);

        $this->assertNotEmpty($result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     * @dataProvider provide_different_styling_for_a_link
     */
    public function it_can_format_a_link_with_custom_styling_from_call_options($url, $options, $expected)
    {
        $result = $this->formatter->formatElement('facebook', $url, $options);

        $this->assertEquals($expected, $result);
    }

    public function provide_different_styling_for_a_link()
    {
        return [
            'check class option' => [
                'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com',
                ['class' => 'tested'],
                '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button tested"><span class="fab fa-facebook-square"></span></a></li>',
            ],
            'check id option' => [
                'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com',
                ['id' => 'tested'],
                '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button" id="tested"><span class="fab fa-facebook-square"></span></a></li>',
            ],
            'check title option' => [
                'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com',
                ['title' => 'tested'],
                '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button" title="tested"><span class="fab fa-facebook-square"></span></a></li>',
            ],
            'check rel option' => [
                'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com',
                ['rel' => 'nofollow'],
                '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li>',
            ],
            'check mass options' => [
                'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com',
                ['rel' => 'nofollow', 'title' => 'Title', 'id' => 'click', 'class' => 'hover active'],
                '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button hover active" id="click" title="Title" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li>',
            ],
        ];
    }

    /** @test */
    public function it_cannot_format_an_element_with_custom_styling_from_call_options()
    {
        $expected = '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button"><span class="fab fa-facebook-square"></span></a></li>';

        $result = $this->formatter->formatElement('facebook',
            'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com',
            ['element_prefix' => '<p>', 'element_suffix' => '</p>']);

        $this->assertNotEmpty($result);
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_cannot_override_arguments_by_options()
    {
        $expected = '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button arguments" id="arguments" title="arguments" rel="arguments"><span class="fab fa-facebook-square"></span></a></li>';
        $this->formatter->updateOptions([
            'class' => 'options',
            'id' => 'options',
            'title' => 'options',
            'rel' => 'options',
        ]);

        $result = $this->formatter->formatElement(
            'facebook',
            'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com',
            [
                'class' => 'arguments',
                'id' => 'arguments',
                'title' => 'arguments',
                'rel' => 'arguments',
            ]);

        $this->assertNotEmpty($result);
        $this->assertEquals($expected, $result);
    }
}
