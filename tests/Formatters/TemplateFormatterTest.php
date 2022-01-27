<?php

namespace Kudashevs\ShareButtons\Tests\Formatters;

use Kudashevs\ShareButtons\Formatters\TemplateFormatter;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TemplateFormatterTest extends ExtendedTestCase
{
    /**
     * @var TemplateFormatter
     */
    private $formatter;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application

        $this->formatter = new TemplateFormatter();
    }

    /** @test */
    public function it_can_return_options()
    {
        $result = $this->formatter->getOptions();

        $this->assertNotEmpty($result);
    }

    /**
     * @test
     * @dataProvider provide_different_formatter_setup_from_options
     * @param array $options
     * @param string $key
     * @param string $expected
     */
    public function it_can_setup_value_from_options(array $options, string $key, string $expected)
    {
        $this->formatter->updateOptions($options);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey($key, $result);
        $this->assertSame($expected, $result[$key]);
    }

    public function provide_different_formatter_setup_from_options()
    {
        return [
            'block_prefix option is not empty' => [
                ['block_prefix' => '<div>'],
                'block_prefix',
                '<div>',
            ],
            'block_prefix option is empty' => [
                ['block_prefix' => ''],
                'block_prefix',
                '',
            ],
            'block_suffix option is not empty' => [
                ['block_suffix' => '</div>'],
                'block_suffix',
                '</div>',
            ],
            'block_suffix option is empty' => [
                ['block_suffix' => ''],
                'block_suffix',
                '',
            ],
            'element_prefix option is not empty' => [
                ['element_prefix' => '<p>'],
                'element_prefix',
                '<p>',
            ],
            'element_prefix option is empty' => [
                ['element_prefix' => ''],
                'element_prefix',
                '',
            ],
            'element_suffix option is not empty' => [
                ['element_suffix' => '</p>'],
                'element_suffix',
                '</p>',
            ],
            'element_suffix option is empty' => [
                ['element_suffix' => ''],
                'element_suffix',
                '',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider provide_different_formatter_setup_from_config
     * @param string $configuration
     * @param string $key
     */
    public function it_can_setup_default_value_without_options(string $configuration, string $key)
    {
        $expected = config($configuration);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey($key, $result);
        $this->assertSame($expected, $result[$key]);
    }

    public function provide_different_formatter_setup_from_config()
    {
        return [
            'default block_prefix' => [
                'share-buttons.block_prefix',
                'block_prefix',
            ],
            'default block_suffix' => [
                'share-buttons.block_suffix',
                'block_suffix',
            ],
            'default element_prefix' => [
                'share-buttons.element_prefix',
                'element_prefix',
            ],
            'default element_suffix' => [
                'share-buttons.element_suffix',
                'element_suffix',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider provide_different_formatter_setup_from_options_for_styling
     * @param array $options
     * @param string $method
     * @param string $expected
     */
    public function it_can_return_formatter_styling_from_options(array $options, string $method, string $expected)
    {
        $this->formatter->updateOptions($options);

        $result = $this->formatter->$method();

        $this->assertSame($expected, $result);
    }

    public function provide_different_formatter_setup_from_options_for_styling()
    {
        return [
            'getBlockPrefix method' => [
                ['block_prefix' => '<p>'],
                'getBlockPrefix',
                '<p>',
            ],
            'getBlockSuffix method' => [
                ['block_suffix' => '</p>'],
                'getBlockSuffix',
                '</p>',
            ],
            'getElementPrefix method' => [
                ['element_prefix' => '<article>'],
                'getElementPrefix',
                '<article>',
            ],
            'getElementSuffix method' => [
                ['element_suffix' => '</article>'],
                'getElementSuffix',
                '</article>',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider provide_different_formatter_setup_from_config_for_styling
     * @param string $configuration
     * @param string $method
     */
   public function it_can_return_formatter_styling_without_options(string $configuration, string $method)
    {
        $expected = config($configuration);

        $result = $this->formatter->$method();

        $this->assertSame($expected, $result);
    }

    public function provide_different_formatter_setup_from_config_for_styling()
    {
        return [
            'getBlockPrefix method' => [
                'share-buttons.block_prefix',
                'getBlockPrefix',
            ],
            'getBlockSuffix method' => [
                'share-buttons.block_suffix',
                'getBlockSuffix',
            ],
            'getElementPrefix method' => [
                'share-buttons.element_prefix',
                'getElementPrefix',
            ],
            'getElementSuffix method' => [
                'share-buttons.element_suffix',
                'getElementSuffix',
            ],
        ];
    }

    /** @test */
    public function it_can_format_an_element_with_default_styling()
    {
        $expected = '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button"><span class="fab fa-facebook-square"></span></a></li>';

        $result = $this->formatter->formatElement('facebook',
            'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com', []);

        $this->assertNotEmpty($result);
        $this->assertEquals($expected, $this->applyElementWrapping($result));
    }

    /** @test */
    public function it_can_format_an_element_with_custom_styling_from_formatter_options()
    {
        $this->formatter->updateOptions(['element_prefix' => '<p>', 'element_suffix' => '</p>']);

        $expected = '<p><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button"><span class="fab fa-facebook-square"></span></a></p>';

        $result = $this->formatter->formatElement('facebook',
            'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com', []);

        $this->assertNotEmpty($result);
        $this->assertEquals($expected, $this->applyElementWrapping($result));
    }

    /**
     * @test
     * @dataProvider provide_different_styling_for_a_link
     */
    public function it_can_format_a_link_with_custom_styling_from_call_options($url, $options, $expected)
    {
        $result = $this->formatter->formatElement('facebook', $url, $options);

        $this->assertEquals($expected, $this->applyElementWrapping($result));
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
        $this->assertEquals($expected, $this->applyElementWrapping($result));
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
        $this->assertEquals($expected, $this->applyElementWrapping($result));
    }

    /**
     * @param string $result
     * @return string
     */
    private function applyElementWrapping(string $result): string
    {
        return $this->formatter->getElementPrefix() . $result . $this->formatter->getElementSuffix();
    }
}
