<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

use Kudashevs\ShareButtons\Templaters\Templater;

class TemplateBasedUrlPresenter
{
    // Some extras are not supposed to be a part of the substitution process.
    const EXTRA_EXCLUSIONS = ['raw', 'hash'];

    protected Templater $templater;

    protected string $name;

    public function __construct(Templater $templater)
    {
        $this->templater = $templater;
    }

    /**
     * Return a button's ready-to-use URL.
     *
     * @param string $name
     * @param array{url: string, text: string, summary?: string, ...<string, string>} $arguments
     * @return string
     */
    public function generateUrl(string $name, array $arguments): string
    {
        $this->initElementName($name);

        $template = $this->retrieveUrlTemplate();
        $replacements = $this->retrieveUrlReplacements($arguments);

        $processedReplacements = $this->selfProcessReplacements($replacements);
        $encodedReplacements = $this->encodeReplacements($processedReplacements);

        return $this->templater->process($template, $encodedReplacements);
    }

    protected function initElementName(string $name): void
    {
        $this->name = $name;
    }

    protected function retrieveUrlTemplate(): string
    {
        $url = config('share-buttons.buttons.' . $this->name . '.url', '');

        return $this->isHash()
            ? '#'
            : $url;
    }

    protected function isHash(): bool
    {
        return config()->has('share-buttons.buttons.' . $this->name . '.extra.hash')
            && config('share-buttons.buttons.' . $this->name . '.extra.hash') === true;
    }

    /**
     * @param array<string, string> $arguments
     * @return array<string, string>
     */
    protected function retrieveUrlReplacements(array $arguments): array
    {
        $elementReplacements = $this->retrieveElementReplacements();
        $applicableArguments = $this->retrieveApplicableArguments($arguments);

        // The arguments override replacements because they have a higher priority.
        return array_merge($elementReplacements, $applicableArguments);
    }

    /**
     * @return array<string, string>
     */
    protected function retrieveElementReplacements(): array
    {
        return array_merge([
            'text' => $this->retrieveText(),
        ], $this->retrieveExtras());
    }

    /**
     * @param array<string, string> $arguments
     * @return array<string, string>
     */
    protected function retrieveApplicableArguments(array $arguments): array
    {
        return array_filter($arguments, function ($value, $key) {
            return is_string($value) && ($value !== '' || $key === 'url');
        }, ARRAY_FILTER_USE_BOTH);
    }

    protected function retrieveText(): string
    {
        return config('share-buttons.buttons.' . $this->name . '.text', '');
    }

    /**
     * @return array<string, string>
     */
    protected function retrieveExtras(): array
    {
        $extras = config('share-buttons.buttons.' . $this->name . '.extra', []);

        return array_diff_key($extras, array_flip(self::EXTRA_EXCLUSIONS));
    }

    /**
     * Process retrieved replacements. The self-processing includes:
     * - replace an url element with a provided page URL
     *
     * @param array{url: string, text: string, summary?: string, ...<string, string>} $replacements
     * @return array{url: string, text: string, summary?: string, ...<string, string>}
     */
    protected function selfProcessReplacements(array $replacements): array
    {
        if (array_key_exists('text', $replacements)) {
            $replacements['text'] = $this->selfProcessText($replacements);
        }

        return $replacements;
    }

    /**
     * @param array{url: string, text: string, summary?: string, ...<string, string>} $replacements
     * @return string
     */
    protected function selfProcessText(array $replacements): string
    {
        return $this->templater->process(
            $replacements['text'],
            $replacements,
        );
    }

    /**
     * @param array<string, string> $replacements
     * @return array<string, string>
     */
    protected function encodeReplacements(array $replacements): array
    {
        return array_map(function (string $value): string {
            return $this->isRaw()
                ? (string)$value
                : urlencode($value);
        }, $replacements);
    }

    protected function isRaw(): bool
    {
        return config()->has('share-buttons.buttons.' . $this->name . '.extra.raw')
            || config('share-buttons.buttons.' . $this->name . '.extra.raw') === true;
    }
}
