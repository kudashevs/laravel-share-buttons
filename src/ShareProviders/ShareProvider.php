<?php

namespace Kudashevs\ShareButtons\ShareProviders;

use Kudashevs\ShareButtons\Exceptions\InvalidProviderException;
use Kudashevs\ShareButtons\Templaters\LaravelTemplater;
use Kudashevs\ShareButtons\Templaters\Templater;

abstract class ShareProvider
{
    /**
     * @param string $link
     * @param string $title
     * @param array $options
     * @return string
     */
    abstract public function buildUrl(string $link, string $title, array $options): string;

    protected string $name;

    protected Templater $templater;

    /**
     * @param string $name
     */
    final public function __construct()
    {
        $this->checkInternals();

        $this->initTemplater();
    }

    /**
     * @throws InvalidProviderException
     */
    protected function checkInternals(): void
    {
        $this->checkValidProvider($this->name);
    }

    protected function checkValidProvider(string $name): void
    {
        if (!ShareProviderFactory::isValidProvider($this->name, static::class)) {
            throw new InvalidProviderException(
                sprintf('The %s is not a valid name for the %s.', $name, static::class)
            );
        }
    }

    protected function initTemplater(): void
    {
        $this->templater = $this->createTemplater();
    }

    protected function createTemplater(): Templater
    {
        return new LaravelTemplater();
    }

    final protected function retrieveProviderUrl(): string
    {
        return config('share-buttons.providers.' . $this->name . '.url', '');
    }

    /**
     * Gather and prepare all the settings.
     *
     * @param string $link
     * @param string $title
     * @param array $options
     * @return array
     */
    final protected function prepareReplacements(string $link, string $title, array $options = []): array
    {
        $basicReplacements = [
            'url' => $link,
            'title' => $this->prepareTitle($title),
        ];

        $extraReplacements = $this->prepareExtras($options);

        return array_merge($extraReplacements, $basicReplacements);
    }

    protected function prepareTitle(string $title): string
    {
        $text = config('share-buttons.providers.' . $this->name . '.text', '');

        $result = (empty($title) && !empty($text))
            ? $text
            : $title;

        return urlencode($result);
    }

    protected function prepareExtras(array $options): array
    {
        $extra = config('share-buttons.providers.' . $this->name . '.extra', []);

        return array_map(static function ($value) {
            return urlencode($value);
        }, array_merge($extra, $options));
    }
}
