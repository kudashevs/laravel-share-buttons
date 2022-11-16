<?php

namespace Kudashevs\ShareButtons\Tests\Formatters;

use Kudashevs\ShareButtons\Formatters\TemplateFormatter;
use Kudashevs\ShareButtons\ShareProviders\Providers\Facebook;
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

    /**
     * @test
     * @dataProvider provideDifferentStylingOptions
     */
    public function it_can_set_values_from_options(array $options, string $method, string $expected)
    {
        $this->formatter->updateOptions($options);

        $result = $this->formatter->$method();

        $this->assertSame($expected, $result);
    }

    public function provideDifferentStylingOptions()
    {
        return [
            'block_prefix option is not empty' => [
                ['block_prefix' => '<div>'],
                'getBlockPrefix',
                '<div>',
            ],
            'block_prefix option is empty' => [
                ['block_prefix' => ''],
                'getBlockPrefix',
                '',
            ],
            'block_suffix option is not empty' => [
                ['block_suffix' => '</div>'],
                'getBlockSuffix',
                '</div>',
            ],
            'block_suffix option is empty' => [
                ['block_suffix' => ''],
                'getBlockSuffix',
                '',
            ],
            'element_prefix option is not empty' => [
                ['element_prefix' => '<p>'],
                'getElementPrefix',
                '<p>',
            ],
            'element_prefix option is empty' => [
                ['element_prefix' => ''],
                'getElementPrefix',
                '',
            ],
            'element_suffix option is not empty' => [
                ['element_suffix' => '</p>'],
                'getElementSuffix',
                '</p>',
            ],
            'element_suffix option is empty' => [
                ['element_suffix' => ''],
                'getElementSuffix',
                '',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider provideDifferentGetStylingMethods
     */
    public function it_can_set_default_values_without_options(string $method, string $expected)
    {
        $expected = config($configuration);

        $result = $this->formatter->$method();

        $this->assertSame($expected, $result);
    }

    public function provideDifferentGetStylingMethods()
    {
        return [
            'default block_prefix' => [
                'share-buttons.block_prefix',
                'getBlockPrefix',
                'block_prefix',
            ],
            'default block_suffix' => [
                'share-buttons.block_suffix',
                'getBlockSuffix',
                'block_suffix',
            ],
            'default element_prefix' => [
                'share-buttons.element_prefix',
                'getElementPrefix',
                'element_prefix',
            ],
            'default element_suffix' => [
                'share-buttons.element_suffix',
                'getElementSuffix',
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

    /** @test */
    public function it_can_format_an_element_with_default_styling()
    {
        $expected = '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=test" class="social-button"><span class="fab fa-facebook-square"></span></a></li>';
        $provider = Facebook::createFromMethodCall('https://mysite.com', 'test', []);

        $result = $this->formatter->getElementBody($provider);

        $this->assertNotEmpty($result);
        $this->assertEquals($expected, $this->applyElementWrapping($result));
    }

    /** @test */
    public function it_can_format_an_element_with_custom_styling_from_formatter_options()
    {
        $expected = '<p><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=Default+share+text" class="social-button"><span class="fab fa-facebook-square"></span></a></p>';
        $provider = Facebook::createFromMethodCall('https://mysite.com', '', []);
        $this->formatter->updateOptions(['element_prefix' => '<p>', 'element_suffix' => '</p>']);

        $result = $this->formatter->getElementBody($provider);

        $this->assertNotEmpty($result);
        $this->assertEquals($expected, $this->applyElementWrapping($result));
    }

    /**
     * @test
     * @dataProvider provideShareProviderDifferentStylingOptions
     */
    public function it_can_format_a_link_with_custom_styling_from_call_options(
        $page,
        $options,
        $expected
    ) {
        $provider = Facebook::createFromMethodCall($page, 'Title', $options);

        $result = $this->formatter->getElementBody($provider);

        $this->assertEquals($expected, $this->applyElementWrapping($result));
    }

    public function provideShareProviderDifferentStylingOptions()
    {
        return [
            'check class option' => [
                'https://mysite.com',
                [
                    'class' => 'tested',
                ],
                '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=Title" class="social-button tested"><span class="fab fa-facebook-square"></span></a></li>',
            ],
            'check id option' => [
                'https://mysite.com',
                [
                    'id' => 'tested',
                ],
                '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=Title" class="social-button" id="tested"><span class="fab fa-facebook-square"></span></a></li>',
            ],
            'check title option' => [
                'https://mysite.com',
                [
                    'title' => 'tested',
                ],
                '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=Title" class="social-button" title="tested"><span class="fab fa-facebook-square"></span></a></li>',
            ],
            'check rel option' => [
                'https://mysite.com',
                [
                    'rel' => 'nofollow',
                ],
                '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=Title" class="social-button" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li>',
            ],
            'check mass options' => [
                'https://mysite.com',
                [
                    'rel' => 'nofollow',
                    'title' => 'Title',
                    'id' => 'click',
                    'class' => 'hover active',
                ],
                '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=Title" class="social-button hover active" id="click" title="Title" rel="nofollow"><span class="fab fa-facebook-square"></span></a></li>',
            ],
        ];
    }

    /** @test */
    public function it_cannot_format_an_element_with_custom_styling_from_call_options()
    {
        $expected = '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=Title" class="social-button"><span class="fab fa-facebook-square"></span></a></li>';
        $provider = Facebook::createFromMethodCall(
            'https://mysite.com',
            'Title',
            [
                'element_prefix' => '<p>',
                'element_suffix' => '</p>',
            ]
        );

        $result = $this->formatter->getElementBody($provider);

        $this->assertNotEmpty($result);
        $this->assertEquals($expected, $this->applyElementWrapping($result));
    }

    /** @test */
    public function it_cannot_override_arguments_with_options()
    {
        $expected = '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com&quote=Title" class="social-button arguments" id="arguments" title="arguments" rel="arguments"><span class="fab fa-facebook-square"></span></a></li>';
        $provider = Facebook::createFromMethodCall(
            'https://mysite.com',
            'Title',
            [
                'class' => 'arguments',
                'id' => 'arguments',
                'title' => 'arguments',
                'rel' => 'arguments',
            ]
        );
        $this->formatter->updateOptions([
            'class' => 'options',
            'id' => 'options',
            'title' => 'options',
            'rel' => 'options',
        ]);

        $result = $this->formatter->getElementBody($provider);

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
