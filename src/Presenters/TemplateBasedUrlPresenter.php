<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

use Kudashevs\ShareButtons\Templaters\Templater;

class TemplateBasedUrlPresenter
{
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
     * @param array{url: string, text: string, summary?: string} $arguments
     * @return string
     */
    public function generateUrl(string $name, array $arguments): string
    {
        $this->initElementName($name);

        $template = $this->retrieveUrlTemplate();
        $replacements = $this->retrieveUrlReplacements($arguments);

        $encodedReplacements = $this->encodeReplacements($replacements);

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
        $applicableArguments = array_filter($arguments, fn($argument) => $argument !== '');

        // Arguments override replacements because they have a higher priority.
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

    protected function retrieveText(): string
    {
        return config('share-buttons.buttons.' . $this->name . '.text', '');
    }

    /**
     * @return array<string, string>
     */
    protected function retrieveExtras(): array
    {
        return config('share-buttons.buttons.' . $this->name . '.extra', []);
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
