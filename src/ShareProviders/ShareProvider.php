<?php

namespace Kudashevs\ShareButtons\ShareProviders;

use Kudashevs\ShareButtons\Exceptions\InvalidShareProviderNameException;
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

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Templater
     */
    protected $templater;

    /**
     * @param string $name
     */
    final public function __construct(string $name)
    {
        $this->initName($name);
        $this->initTemplater();
    }

    /**
     * @param string $name
     * @return void
     */
    private function initName(string $name): void
    {
        if (!$this->isValidName($name)) {
            throw new InvalidShareProviderNameException('The ' . $name . ' is not a valid name for the ' . static::class . '.');
        }

        $this->name = $name;
    }

    /**
     * @param string $name
     * @return bool
     */
    private function isValidName(string $name): bool
    {
        $providers = Factory::getProviders();

        return array_key_exists($name, $providers) && $providers[$name] === static::class;
    }

    /**
     * @return void
     */
    private function initTemplater(): void
    {
        $this->templater = $this->createTemplater();
    }

    /**
     * @return Templater
     */
    protected function createTemplater(): Templater
    {
        return new LaravelTemplater();
    }

    /**
     * @return string
     */
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

    /**
     * @param string $title
     * @return string
     */
    private function prepareTitle(string $title): string
    {
        $text = config('share-buttons.providers.' . $this->name . '.text', '');

        $result = (empty($title) && !empty($text))
            ? $text
            : $title;

        return urlencode($result);
    }

    /**
     * @param array $options
     * @return array
     */
    private function prepareExtras(array $options): array
    {
        $extra = config('share-buttons.providers.' . $this->name . '.extra', []);

        return array_map(static function ($value) {
            return urlencode($value);
        }, array_merge($extra, $options));
    }
}
