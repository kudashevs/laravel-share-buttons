<?php

namespace Kudashevs\ShareButtons\Tests\Unit\Presenters;

use Kudashevs\ShareButtons\Presenters\TemplateBasedElementPresenter;
use Kudashevs\ShareButtons\Templaters\SimpleColonTemplater;
use Kudashevs\ShareButtons\Templaters\Templater;
use Kudashevs\ShareButtons\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class TemplateBasedElementPresenterTest extends TestCase
{
    const DEFAULT_ELEMENT_PREFIX = '';
    const DEFAULT_ELEMENT_SUFFIX = '';

    private TemplateBasedElementPresenter $presenter;

    protected function setUp(): void
    {
        parent::setUp();

        $templater = $this->createDefaultTemplater();
        $this->presenter = new TemplateBasedElementPresenter($templater);
    }

    #[Test]
    #[DataProvider('provideDifferentPresentationOptions')]
    public function it_can_retrieve_presentation_data_from_options(
        array $options,
        string $method,
        string $expected
    ): void {
        $this->presenter->refresh($options);

        $presentation = $this->presenter->$method();

        $this->assertSame($expected, $presentation);
    }

    public static function provideDifferentPresentationOptions(): array
    {
        return [
            'no options provided results in the default prefix' => [
                [],
                'getElementPrefix',
                self::DEFAULT_ELEMENT_PREFIX,
            ],
            'no options provided results in the default suffix' => [
                [],
                'getElementSuffix',
                self::DEFAULT_ELEMENT_SUFFIX,
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

    #[Test]
    #[DataProvider('provideDifferentPresentationConfigurations')]
    public function it_can_retrieve_presentation_data_from_configuration(string $configuration, string $method): void
    {
        $expected = config('share-buttons.' . $configuration);

        $presentation = $this->presenter->$method();

        $this->assertSame($expected, $presentation);
    }

    public static function provideDifferentPresentationConfigurations(): array
    {
        return [
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

    #[Test]
    public function it_can_retrieve_values_from_configuration_on_refresh(): void
    {
        $elementPrefix = '<element>';
        $elementSuffix = '</element>';

        config()->set('share-buttons.element_prefix', $elementPrefix);
        config()->set('share-buttons.element_suffix', $elementSuffix);

        $this->presenter->refresh();

        $this->assertEquals($elementPrefix, $this->presenter->getElementPrefix());
        $this->assertEquals($elementSuffix, $this->presenter->getElementSuffix());
    }

    #[Test]
    public function it_cannot_update_values_from_arguments_with_wrong_type_on_refresh(): void
    {
        $this->presenter->refresh(['element_prefix' => 42, 'element_suffix' => 42]);

        $this->assertEquals(self::DEFAULT_ELEMENT_PREFIX, $this->presenter->getElementPrefix());
        $this->assertEquals(self::DEFAULT_ELEMENT_SUFFIX, $this->presenter->getElementSuffix());
    }

    #[Test]
    public function it_can_update_values_from_arguments_with_correct_type_on_refresh(): void
    {
        $elementPrefix = '<p>';
        $elementSuffix = '</p>';

        $this->presenter->refresh(['element_prefix' => $elementPrefix, 'element_suffix' => $elementSuffix]);

        $this->assertEquals($elementPrefix, $this->presenter->getElementPrefix());
        $this->assertEquals($elementSuffix, $this->presenter->getElementSuffix());
    }

    #[Test]
    #[DataProvider('provideDifferentAttributeOptions')]
    public function it_can_apply_provided_attributes_to_an_element(
        string $url,
        array $options,
        string $expected
    ): void {
        $elementBody = $this->presenter->getElementBody(
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
                'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title',
                [
                    'class' => 'tested',
                ],
                '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title" class="social-button tested"><span class="fab fa-facebook-square"></span></a>',
            ],
            'check id option' => [
                'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title',
                [
                    'id' => 'tested',
                ],
                '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title" class="social-button" id="tested"><span class="fab fa-facebook-square"></span></a>',
            ],
            'check title option' => [
                'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title',
                [
                    'title' => 'tested',
                ],
                '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title" class="social-button" title="tested"><span class="fab fa-facebook-square"></span></a>',
            ],
            'check rel option' => [
                'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title',
                [
                    'rel' => 'nofollow',
                ],
                '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title" class="social-button" rel="nofollow"><span class="fab fa-facebook-square"></span></a>',
            ],
            'check all of the options' => [
                'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title',
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

    #[Test]
    public function it_cannot_override_presentation_data_with_options_provided_directly_without_calling_refresh_method(): void
    {
        $expected = '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title" class="social-button"><span class="fab fa-facebook-square"></span></a>';

        $element = $this->presenter->getElementBody(
            'facebook',
            [
                'url' => 'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title',
                'text' => 'Title',
                'element_prefix' => '<wrong>',
                'element_suffix' => '</wrong>',
            ]
        );

        $this->assertEquals($expected, $element);
    }

    #[Test]
    public function it_cannot_override_presentation_data_from_arguments_with_options_provided_through_refresh_method(): void
    {
        $expected = '<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title" class="social-button arguments" id="arguments" title="arguments" rel="arguments"><span class="fab fa-facebook-square"></span></a>';

        $this->presenter->refresh([
            'class' => 'options',
            'id' => 'options',
            'title' => 'options',
            'rel' => 'options',
        ]);

        $element = $this->presenter->getElementBody(
            'facebook',
            [
                'url' => 'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmysite.com&quote=Title',
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
        return $this->presenter->getElementPrefix()
            . $this->presenter->getElementBody($name, $arguments)
            . $this->presenter->getElementSuffix();
    }

    private function createDefaultTemplater(): Templater
    {
        return new SimpleColonTemplater();
    }
}
