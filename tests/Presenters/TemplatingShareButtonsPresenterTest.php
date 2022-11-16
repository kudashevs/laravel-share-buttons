<?php

namespace Kudashevs\ShareButtons\Tests\Presenters;

use Kudashevs\ShareButtons\Presenters\TemplatingShareButtonsPresenter;
use Kudashevs\ShareButtons\ShareProviders\Providers\Facebook;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TemplatingShareButtonsPresenterTest extends ExtendedTestCase
{
    /**
     * @var TemplatingShareButtonsPresenter
     */
    private $formatter;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application

        $this->formatter = new TemplatingShareButtonsPresenter();
    }

    /**
     * @test
     * @dataProvider provideDifferentStylingOptions
     */
    public function it_can_set_values_from_options(array $options, string $method, string $expected)
    {
        $this->formatter->refreshStyling($options);

        $result = $this->formatter->$method();

        $this->assertSame($expected, $result);
    }

    public function provideDifferentStylingOptions()
    {
        return [
            'block_prefix option with open div results in open div' => [
                ['block_prefix' => '<div>'],
                'getBlockPrefix',
                '<div>',
            ],
            'block_suffix option with close div results in close div' => [
                ['block_suffix' => '</div>'],
                'getBlockSuffix',
                '</div>',
            ],
            'block_prefix option with open p results in open p' => [
                ['block_prefix' => '<p>'],
                'getBlockPrefix',
                '<p>',
            ],
            'block_prefix option with close p results in close p' => [
                ['block_suffix' => '</p>'],
                'getBlockSuffix',
                '</p>',
            ],
            'block_prefix option with open article results in open article' => [
                ['element_prefix' => '<article>'],
                'getElementPrefix',
                '<article>',
            ],
            'block_prefix option with close article results in close article' => [
                ['element_suffix' => '</article>'],
                'getElementSuffix',
                '</article>',
            ],
            'block_prefix option with empty string results in empty string' => [
                ['block_prefix' => ''],
                'getBlockPrefix',
                '',
            ],
            'block_suffix option with empty string results in empty string' => [
                ['block_suffix' => ''],
                'getBlockSuffix',
                '',
            ],
            'element_prefix option with open p results in open p' => [
                ['element_prefix' => '<p>'],
                'getElementPrefix',
                '<p>',
            ],
            'element_suffix option with close p results in close p' => [
                ['element_suffix' => '</p>'],
                'getElementSuffix',
                '</p>',
            ],
            'element_prefix option with open span results in open span' => [
                ['element_prefix' => '<span>'],
                'getElementPrefix',
                '<span>',
            ],
            'element_suffix option with close span results in close span' => [
                ['element_suffix' => '</span>'],
                'getElementSuffix',
                '</span>',
            ],
            'element_prefix option with empty string results in empty string' => [
                ['element_prefix' => ''],
                'getElementPrefix',
                '',
            ],
            'element_suffix option with empty string results in empty string' => [
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
        $result = $this->formatter->$method();

        $this->assertSame($expected, $result);
    }

    public function provideDifferentGetStylingMethods()
    {
        return [
            'block_prefix results in the default' => [
                'getBlockPrefix',
                '<div id="social-links"><ul>',
            ],
            'block_suffix results in the default' => [
                'getBlockSuffix',
                '</ul></div>',
            ],
            'element_prefix results in the default' => [
                'getElementPrefix',
                '<li>',
            ],
            'element_suffix results in the default' => [
                'getElementSuffix',
                '</li>',
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
        $this->formatter->refreshStyling(['element_prefix' => '<p>', 'element_suffix' => '</p>']);

        $result = $this->formatter->getElementBody($provider);

        $this->assertNotEmpty($result);
        $this->assertEquals($expected, $this->applyElementWrapping($result));
    }

    /**
     * @test
     * @dataProvider provideShareProviderDifferentStylingOptions
     */
    public function it_can_format_a_link_with_custom_styling_from_call_options(
        string $page,
        array $options,
        string $expected
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
        $this->formatter->refreshStyling([
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
