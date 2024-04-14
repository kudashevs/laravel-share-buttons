<?php

namespace Kudashevs\ShareButtons\Tests\Unit\Presenters;

use Kudashevs\ShareButtons\Exceptions\InvalidOptionValue;
use Kudashevs\ShareButtons\Presenters\TemplateBasedPresenterMediator;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TemplateBasedPresenterMediatorTest extends ExtendedTestCase
{
    private TemplateBasedPresenterMediator $mediator;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application

        $this->mediator = new TemplateBasedPresenterMediator();
    }

    /** @test */
    public function it_can_throw_an_exception_when_a_wrong_templater_option(): void
    {
        $this->expectException(InvalidOptionValue::class);
        $this->expectExceptionMessage('not a valid');

        new TemplateBasedPresenterMediator([
            'templater' => \stdClass::class,
        ]);
    }

    /** @test */
    public function it_can_throw_an_exception_when_a_wrong_url_templater_option(): void
    {
        $this->expectException(InvalidOptionValue::class);
        $this->expectExceptionMessage('not a valid');

        new TemplateBasedPresenterMediator([
            'url_templater' => \stdClass::class,
        ]);
    }

    /**
     * @test
     * @dataProvider provideDifferentPresentationOptions
     */
    public function it_can_retrieve_presentation_data_from_options(
        array $options,
        string $method,
        string $expected
    ): void {
        $this->mediator->refresh($options);

        $presentation = $this->mediator->$method();

        $this->assertSame($expected, $presentation);
    }

    public static function provideDifferentPresentationOptions(): array
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
            'block_suffix option with close p results in close p' => [
                ['block_suffix' => '</p>'],
                'getBlockSuffix',
                '</p>',
            ],
            'block_prefix option with open article results in open article' => [
                ['block_prefix' => '<article>'],
                'getBlockPrefix',
                '<article>',
            ],
            'block_suffix option with close article results in close article' => [
                ['block_suffix' => '</article>'],
                'getBlockSuffix',
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
     * @dataProvider provideDifferentPresentationConfigurations
     */
    public function it_can_retrieve_presentation_data_from_configuration(string $configuration, string $method): void
    {
        $expected = config('share-buttons.' . $configuration);

        $presentation = $this->mediator->$method();

        $this->assertSame($expected, $presentation);
    }

    public static function provideDifferentPresentationConfigurations(): array
    {
        return [
            'block_prefix results in the default' => [
                'block_prefix',
                'getBlockPrefix',
            ],
            'block_suffix results in the default' => [
                'block_suffix',
                'getBlockSuffix',
            ],
            'element_prefix results in the default' => [
                'element_prefix',
                'getElementPrefix',
            ],
            'element_suffix results in the default' => [
                'element_suffix',
                'getElementSuffix',
            ],
        ];
    }

    /** @test */
    public function it_can_format_an_element_with_presentation_data_from_configuration(): void
    {
        $elementPrefix = config('share-buttons.element_prefix');
        $elementSuffix = config('share-buttons.element_suffix');
        $elementBody = '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=test" class="social-button"><span class="fab fa-facebook-square"></span></a>';
        $expected = $elementPrefix . $elementBody . $elementSuffix;

        $element = $this->generateElement(
            'facebook',
            [
                'url' => 'https://mysite.com',
                'text' => 'test',
            ]
        );

        $this->assertEquals($expected, $element);
    }

    /** @test */
    public function it_can_format_an_element_with_presentation_data_from_options_provided_through_refresh_method(): void
    {
        $elementPrefix = '<p>';
        $elementSuffix = '</p>';
        $elementBody = '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Default+share+text" class="social-button"><span class="fab fa-facebook-square"></span></a>';
        $expected = $elementPrefix . $elementBody . $elementSuffix;

        $this->mediator->refresh(['element_prefix' => $elementPrefix, 'element_suffix' => $elementSuffix]);

        $element = $this->generateElement(
            'facebook',
            [
                'url' => 'https://mysite.com',
                'text' => '',
            ]
        );

        $this->assertEquals($expected, $element);
    }

    /**
     * @test
     * @dataProvider provideDifferentAttributeOptions
     */
    public function it_can_apply_provided_attributes_to_an_element(
        string $url,
        array $options,
        string $expected
    ): void {
        $elementBody = $this->mediator->getElementBody(
            'facebook',
            array_merge([
                'url' => $url,
                'text' => 'Title',
            ], $options)
        );

        $this->assertEquals($expected, $elementBody);
    }

    public static function provideDifferentAttributeOptions(): array
    {
        return [
            'check class option' => [
                'https://mysite.com',
                [
                    'class' => 'tested',
                ],
                '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title" class="social-button tested"><span class="fab fa-facebook-square"></span></a>',
            ],
            'check id option' => [
                'https://mysite.com',
                [
                    'id' => 'tested',
                ],
                '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title" class="social-button" id="tested"><span class="fab fa-facebook-square"></span></a>',
            ],
            'check title option' => [
                'https://mysite.com',
                [
                    'title' => 'tested',
                ],
                '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title" class="social-button" title="tested"><span class="fab fa-facebook-square"></span></a>',
            ],
            'check rel option' => [
                'https://mysite.com',
                [
                    'rel' => 'nofollow',
                ],
                '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title" class="social-button" rel="nofollow"><span class="fab fa-facebook-square"></span></a>',
            ],
            'check all of the options' => [
                'https://mysite.com',
                [
                    'rel' => 'nofollow',
                    'title' => 'Title',
                    'id' => 'click',
                    'class' => 'hover active',
                ],
                '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title" class="social-button hover active" id="click" title="Title" rel="nofollow"><span class="fab fa-facebook-square"></span></a>',
            ],
        ];
    }

    /** @test */
    public function it_cannot_override_presentation_data_with_options_provided_directly_without_calling_refresh_method(
    ): void
    {
        $elementPrefix = config('share-buttons.element_prefix');
        $elementSuffix = config('share-buttons.element_suffix');
        $elementBody = '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title" class="social-button"><span class="fab fa-facebook-square"></span></a>';
        $expected = $elementPrefix . $elementBody . $elementSuffix;

        $element = $this->generateElement(
            'facebook',
            [
                'url' => 'https://mysite.com',
                'text' => 'Title',
                'element_prefix' => '<wrong>',
                'element_suffix' => '</wrong>',
            ]
        );

        $this->assertEquals($expected, $element);
    }

    /** @test */
    public function it_cannot_override_presentation_data_from_arguments_with_options_provided_through_refresh_method(
    ): void
    {
        $elementPrefix = config('share-buttons.element_prefix');
        $elementSuffix = config('share-buttons.element_suffix');
        $elementBody = '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title" class="social-button arguments" id="arguments" title="arguments" rel="arguments"><span class="fab fa-facebook-square"></span></a>';
        $expected = $elementPrefix . $elementBody . $elementSuffix;

        $this->mediator->refresh([
            'class' => 'options',
            'id' => 'options',
            'title' => 'options',
            'rel' => 'options',
        ]);

        $element = $this->generateElement(
            'facebook',
            [
                'url' => 'https://mysite.com',
                'text' => 'Title',
                'class' => 'arguments',
                'id' => 'arguments',
                'title' => 'arguments',
                'rel' => 'arguments',
            ]
        );

        $this->assertEquals($expected, $element);
    }

    /**
     * @param string $name
     * @param array{url: string, text: string, id?: string, class?: string, title?: string, rel?: string} $arguments
     * @return string
     */
    private function generateElement(string $name, array $arguments): string
    {
        return $this->mediator->getElementPrefix()
            . $this->mediator->getElementBody($name, $arguments)
            . $this->mediator->getElementSuffix();
    }
}
