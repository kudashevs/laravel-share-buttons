<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\ShareProviders;

abstract class ShareProvider
{
    protected string $name;

    protected string $text;

    protected array $extras;

    /**
     * @return ShareProvider
     */
    public static function create(): ShareProvider
    {
        return new static();
    }

    public function __construct()
    {
        $this->initProvider();
    }

    protected function initProvider(): void
    {
        $this->text = $this->retrieveText();
        $this->extras = $this->retrieveExtras();
    }

    protected function retrieveUrl(): string
    {
        return config('share-buttons.providers.' . $this->name . '.url', '');
    }

    protected function retrieveText(): string
    {
        return config('share-buttons.providers.' . $this->name . '.text', '');
    }

    protected function retrieveExtras(): array
    {
        return config('share-buttons.providers.' . $this->name . '.extra', []);
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
     * Return a share provider URL text.
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Return provided extras.
     *
     * @return array
     */
    public function getExtras(): array
    {
        return $this->extras;
    }

    /**
     * Return URL template related replacements.
     *
     * @return array<string, string>
     */
    public function getUrlReplacements(): array
    {
        return array_merge([
            'text' => $this->text,
        ], $this->extras);
    }
}
