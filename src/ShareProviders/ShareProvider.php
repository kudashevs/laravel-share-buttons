<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\ShareProviders;

abstract class ShareProvider
{
    protected string $name;

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
}
