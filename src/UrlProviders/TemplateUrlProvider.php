<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\UrlProviders;

use Kudashevs\ShareButtons\Exceptions\InvalidTemplaterFactoryArgument;
use Kudashevs\ShareButtons\Factories\TemplaterFactory;
use Kudashevs\ShareButtons\Templaters\Templater;

class TemplateUrlProvider implements UrlProvider
{
    protected Templater $templater;

    protected string $name;

    public function __construct(array $options = [])
    {
        $this->initTemplater($options);
    }

    /**
     * @throws InvalidTemplaterFactoryArgument
     */
    private function initTemplater(array $options): void
    {
        $this->templater = TemplaterFactory::createFromOptions($options);
    }

    protected function retrieveUrl(): string
    {
        $url = config('share-buttons.providers.' . $this->name . '.url', '');

        return $this->isHashedUrl()
            ? '#'
            : $url;
    }

    protected function isHashedUrl(): bool
    {
        return config()->has('share-buttons.providers.' . $this->name . '.extra.hash') &&
            config('share-buttons.providers.' . $this->name . '.extra.hash') === true;
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
     * @inheritDoc
     */
    public function generateUrl(string $name, array $arguments): string
    {
        $this->initName($name);

        $template = $this->retrieveUrl();
        $replacements = $this->retrieveUrlReplacements($arguments);

        $encoded = $this->encodeReplacements($replacements);

        return $this->templater->render($template, $encoded);
    }

    protected function initName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array<string, string>
     */
    protected function retrieveUrlReplacements(array $arguments): array
    {
        return array_merge($this->getUrlReplacements(), array_filter($arguments, 'strlen'));
    }

    protected function getUrlReplacements(): array
    {
        return array_merge([
            'text' => $this->retrieveText(),
        ], $this->retrieveExtras());
    }

    protected function encodeReplacements(array $replacements): array
    {
        return array_map(function (string $value) {
            return urlencode($value);
        }, $replacements);
    }
}
