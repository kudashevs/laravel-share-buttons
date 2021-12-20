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
     * @param string $title
     * @return string
     */
    final protected function prepareTitle(string $title): string
    {
        $key = 'share-buttons.providers.' . $this->name . '.text';

        if (empty($title) && config()->has($key)) {
            return urlencode(config($key));
        }

        return urlencode($title);
    }
}
