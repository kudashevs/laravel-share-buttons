<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

class TemplateBasedBlockPresenter
{
    /**
     * Contain options related to the visual block representation of share buttons.
     *
     * @var array{block_prefix: string, block_suffix: string}
     */
    protected array $styling = [
        'block_prefix' => '',
        'block_suffix' => '',
    ];

    public function __construct()
    {
        $this->initRepresentation();
    }

    /**
     * @param array{block_prefix?: string, block_suffix?: string} $options
     */
    protected function initRepresentation(array $options = []): void
    {
        $applicable = $this->retrieveApplicableOptions($options);

        $this->initBlockRepresentation($applicable);
    }

    /**
     * @param array<string, string> $options
     * @return array<string, string>
     */
    protected function retrieveApplicableOptions(array $options): array
    {
        return array_filter($options, 'is_string');
    }

    /**
     * @param array{block_prefix?: string, block_suffix?: string} $options
     */
    protected function initBlockRepresentation(array $options): void
    {
        $this->styling['block_prefix'] = $options['block_prefix'] ?? config('share-buttons.block_prefix', '<ul>');
        $this->styling['block_suffix'] = $options['block_suffix'] ?? config('share-buttons.block_suffix', '</ul>');
    }

    /**
     * Refresh styling (style of elements representation) of the share buttons.
     *
     * @param array{block_prefix?: string, block_suffix?: string} $options
     * @return void
     */
    public function refresh(array $options = []): void
    {
        $this->initRepresentation($options);
    }

    /**
     * @see TemplateBasedPresenterMediator::getBlockPrefix()
     */
    public function getBlockPrefix(): string
    {
        return $this->styling['block_prefix'];
    }

    /**
     * @see TemplateBasedPresenterMediator::getBlockSuffix()
     */
    public function getBlockSuffix(): string
    {
        return $this->styling['block_suffix'];
    }
}
