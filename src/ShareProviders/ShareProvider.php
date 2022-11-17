<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\ShareProviders;

use Kudashevs\ShareButtons\Templaters\LaravelTemplater;
use Kudashevs\ShareButtons\Templaters\Templater;

abstract class ShareProvider
{
    protected Templater $templater;

    protected string $name;

    protected string $url = '#';

    protected array $arguments = [];

    protected function __construct()
    {
        $this->initTemplater();
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

    protected function initTemplater(): void
    {
        $this->templater = $this->createTemplater();
    }

    protected function createTemplater(): Templater
    {
        return new LaravelTemplater();
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

    protected function buildUrl(string $link, string $title, array $arguments): string
    {
        $this->rememberProvidedArguments($arguments);

        $template = $this->retrieveProviderUrl();
        $replacements = $this->retrieveReplacements($link, $title, $arguments);

        $this->url = $this->templater->render($template, $replacements);

        return $this->url;
    }

    protected function rememberProvidedArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    protected function retrieveProviderUrl(): string
    {
        return config('share-buttons.providers.' . $this->name . '.url', '');
    }

    /**
     * Gather and prepare all of the settings.
     *
     * @param string $link
     * @param string $title
     * @param array $arguments
     * @return array
     */
    protected function retrieveReplacements(string $link, string $title, array $arguments = []): array
    {
        $initialReplacements = [
            'url' => $link,
            'title' => $this->prepareTitle($title),
        ];

        $extraReplacements = $this->prepareExtras($arguments);

        return array_merge($extraReplacements, $initialReplacements);
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

        return array_map(static function (string $value) {
            return urlencode($value);
        }, array_merge($extra, $arguments));
    }
}
