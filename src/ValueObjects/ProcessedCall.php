<?php

namespace Kudashevs\ShareButtons\ValueObjects;

final class ProcessedCall
{
    /**
     * @var string
     */
    private $provider;

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $options;

    /**
     * @param string $provider
     * @param string $url
     * @param array<string, string> $options
     */
    public function __construct(string $provider, string $url, array $options)
    {
        $this->initProvider($provider);
        $this->initUrl($url);
        $this->initOptions($options);
    }

    private function __clone()
    {
    }

    /**
     * @param string $provider
     * @return string
     */
    private function initProvider(string $provider): void
    {
        if (trim($provider) === '') {
            throw new \InvalidArgumentException('A share provider argument cannot be empty.');
        }

        $this->provider = $provider;
    }

    /**
     * @param string $url
     * @return string
     */
    private function initUrl(string $url): void
    {
        if (trim($url) === '') {
            throw new \InvalidArgumentException('A url argument cannot be empty.');
        }

        $this->url = $url;
    }

    /**
     * @param array<string, string> $options
     */
    private function initOptions(array $options): void
    {
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return array<string, string>
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
