<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\ShareProviders;

abstract class ShareProvider
{
    protected string $name;

    protected string $url = '#';

    protected array $arguments = [];

    protected array $replacements = [];

    protected function __construct()
    {
    }

    /**
     * @return ShareProvider
     */
    public static function create(): ShareProvider
    {
        return new static();
    }

    /**
     * @param string $page
     * @param string $title
     * @param array $arguments
     * @return ShareProvider
     */
    public static function createFromMethodCall(string $page, string $title, array $arguments): ShareProvider
    {
        $instance = new static();
        $instance->buildUrl($page, $title, $arguments);

        return $instance;
    }

    /**
     * Return a share provider name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Return a share provider URL.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Return provided arguments.
     *
     * @return array<string, string>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getReplacements(): array
    {
        return $this->replacements;
    }

    protected function buildUrl(string $link, string $title, array $arguments): void // @todo rename to generateUrl
    {
        $this->rememberProvidedArguments($arguments);

        $this->url = $this->retrieveUrl();
        $this->replacements = $this->retrieveReplacements($link, $title, $arguments);
    }

    protected function rememberProvidedArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    protected function retrieveUrl(): string
    {
        return config('share-buttons.providers.' . $this->name . '.url', '');
    }

    /**
     * Gather and prepare all possible replacements.
     *
     * @param string $link
     * @param string $title
     * @param array $arguments
     * @return array<string, string>
     */
    protected function retrieveReplacements(string $link, string $title, array $arguments = []): array
    {
        $initialReplacements = [
            'url' => $this->prepareLink($link),
            'title' => $this->prepareTitle($title),
        ];

        $extraReplacements = $this->prepareExtras($arguments);

        return array_merge($extraReplacements, $initialReplacements);
    }

    protected function prepareLink(string $link): string
    {
        return $this->isEmptyTitle($link) ? '#' : $link;
    }

    protected function prepareTitle(string $title): string
    {
        $text = config('share-buttons.providers.' . $this->name . '.text', '');

        $result = ($this->isEmptyTitle($title))
            ? $text
            : $title;

        return urlencode($result);
    }

    protected function isEmptyTitle(string $title): bool
    {
        return trim($title) === '';
    }

    protected function prepareExtras(array $arguments): array
    {
        $extra = config('share-buttons.providers.' . $this->name . '.extra', []);

        /**
         * Because provided arguments may overlap extra information we merge them.
         */
        return array_map(static function (string $value) {
            return urlencode($value);
        }, array_merge($extra, $arguments));
    }
}
