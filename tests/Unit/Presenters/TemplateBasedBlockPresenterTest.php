<?php

namespace Kudashevs\ShareButtons\Tests\Unit\Presenters;

use Kudashevs\ShareButtons\Presenters\TemplateBasedBlockPresenter;
use Kudashevs\ShareButtons\Tests\TestCase;

class TemplateBasedBlockPresenterTest extends TestCase
{
    const DEFAULT_BLOCK_PREFIX = '<div id="social-buttons">';
    const DEFAULT_BLOCK_SUFFIX = '</div>';

    private TemplateBasedBlockPresenter $presenter;

    protected function setUp(): void
    {
        parent::setUp();

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
            'no options provided results in the default prefix' => [
                [],
                'getBlockPrefix',
                self::DEFAULT_BLOCK_PREFIX,
            ],
            'no options provided results in the default suffix' => [
                [],
                'getBlockSuffix',
                self::DEFAULT_BLOCK_SUFFIX,
            ],
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

    /** @test */
    public function it_can_retrieve_values_from_configuration_on_refresh(): void
    {
        $blockPrefix = '<element>';
        $blockSuffix = '</element>';

        config()->set('share-buttons.block_prefix', $blockPrefix);
        config()->set('share-buttons.block_suffix', $blockSuffix);

        $this->presenter->refresh();

        $this->assertEquals($blockPrefix, $this->presenter->getBlockPrefix());
        $this->assertEquals($blockSuffix, $this->presenter->getBlockSuffix());
    }

    /** @test */
    public function it_cannot_update_values_from_arguments_with_wrong_type_on_refresh(): void
    {
        $this->presenter->refresh(['block_prefix' => 42, 'block_suffix' => 42]);

        $this->assertEquals(self::DEFAULT_BLOCK_PREFIX, $this->presenter->getBlockPrefix());
        $this->assertEquals(self::DEFAULT_BLOCK_SUFFIX, $this->presenter->getBlockSuffix());
    }


    /** @test */
    public function it_can_update_values_from_arguments_with_correct_type_on_refresh(): void
    {
        $blockPrefix = '<p>';
        $blockSuffix = '</p>';

        $this->presenter->refresh(['block_prefix' => $blockPrefix, 'block_suffix' => $blockSuffix]);

        $this->assertEquals($blockPrefix, $this->presenter->getBlockPrefix());
        $this->assertEquals($blockSuffix, $this->presenter->getBlockSuffix());
    }
}
