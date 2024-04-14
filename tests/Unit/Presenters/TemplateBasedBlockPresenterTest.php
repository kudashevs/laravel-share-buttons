<?php

namespace Kudashevs\ShareButtons\Tests\Unit\Presenters;

use Kudashevs\ShareButtons\Presenters\TemplateBasedBlockPresenter;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TemplateBasedBlockPresenterTest extends ExtendedTestCase
{
    private TemplateBasedBlockPresenter $presenter;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application

        $this->presenter = new TemplateBasedBlockPresenter();
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
        $this->presenter->refresh($options);

        $presentation = $this->presenter->$method();

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
        ];
    }

    /**
     * @test
     * @dataProvider provideDifferentPresentationConfigurations
     */
    public function it_can_retrieve_presentation_data_from_configuration(string $configuration, string $method): void
    {
        $expected = config('share-buttons.' . $configuration);

        $presentation = $this->presenter->$method();

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
        ];
    }
}
