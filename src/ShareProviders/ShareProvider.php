<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\ShareProviders;

abstract class ShareProvider
{
    protected string $name;

    protected string $template;

    protected string $url;

    protected string $text;

    protected function __construct()
    {
        $this->initProvider();
    }

    protected function initProvider(): void
    {
        $this->template = $this->retrieveTemplate();
        $this->url = $this->retrieveUrl();
        $this->text = $this->retrieveText();
    }

    protected function retrieveTemplate(): string
    {
        return config('share-buttons.templates.' . $this->name, '');
    }

    protected function retrieveText(): string
    {
        return config('share-buttons.providers.' . $this->name . '.text', '');
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
     * Return a share provider element template.
     *
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Return a share provider URL template.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Return a share provider URL text.
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    protected function buildUrl(string $link, string $title, array $arguments): void // @todo rename to generateUrl
    {
        $this->url = $this->retrieveUrl();
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
