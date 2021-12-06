<?php

namespace Kudashevs\ShareButtons;

use Kudashevs\ShareButtons\ShareProviders\Factory;

class ShareButtons
{
    /**
     * The url of the page to share.
     *
     * @var string
     */
    protected $url;

    /**
     * Optional text for Twitter and Linkedin title.
     *
     * @var string
     */
    protected $title;

    /**
     * Extra options for the share links.
     *
     * @var array
     */
    protected $options = [
        'prefix' => '<div id="social-links"><ul>',
        'suffix' => '</ul></div>',
        'fontAwesomeVersion' => 5,
    ];

    /**
     * Contains share providers instances.
     *
     * @var array
     */
    private $providers = [];

    /**
     * Contains generated urls.
     *
     * @var string
     */
    protected $generatedUrls = [];

    /**
     * Contains generated representation.
     *
     * @var array
     */
    protected $generatedRepresentation = [];

    /**
     * Share constructor.
     */
    public function __construct(array $options = [])
    {
        $this->initFontAwesomeVersion($options);
        $this->initPrefixAndSuffix($options);
        $this->initProviders();
    }

    /**
     * @param array $options
     */
    private function initFontAwesomeVersion(array $options): void
    {
        if (!empty($options['fontAwesomeVersion']) && is_int($options['fontAwesomeVersion'])) {
            $this->options['fontAwesomeVersion'] = $options['fontAwesomeVersion'];
        }
    }

    /**
     * @param array $options
     */
    private function initPrefixAndSuffix(array $options)
    {
        if (!empty($options['prefix'])) {
            $this->options['prefix'] = $options['prefix'];
        }

        if (!empty($options['suffix'])) {
            $this->options['suffix'] = $options['suffix'];
        }
    }

    /**
     * Initializes share providers.
     *
     * @return void
     */
    private function initProviders(): void
    {
        $this->providers = Factory::create();
    }

    /**
     * @param string $url
     * @param string $title
     * @param array $options
     * @return $this
     */
    public function page(string $url, string $title = '', array $options = []): self
    {
        $this->clearState();

        $this->url = $url;
        $this->title = $title;

        $this->initPrefixAndSuffix($options);

        return $this;
    }

    /**
     * Clear the state of a previous call.
     */
    private function clearState(): void
    {
        $this->generatedUrls = [];
        $this->generatedRepresentation = [];
    }

    /**
     * @param string $title
     * @param array $options
     * @return $this
     */
    public function currentPage(string $title = '', array $options = []): self
    {
        $url = request()->getUri();

        return $this->page($url, $title, $options);
    }

    /**
     * Get the raw generated links.
     *
     * @return array
     */
    public function getRawLinks()
    {
        return $this->generatedUrls;
    }

    /**
     * Build a single link.
     *
     * @param string $provider
     * @param string $url
     */
    protected function buildLink($provider, $url)
    {
        $this->rememberRawLink($provider, $url);

        $this->rememberRepresentation($provider, $url);
    }

    /**
     * Remembers a processed link.
     *
     * @param string $provider
     * @param string $socialNetworkUrl
     */
    protected function rememberRawLink($provider, $socialNetworkUrl)
    {
        $this->generatedUrls[$provider] = $socialNetworkUrl;
    }

    /**
     * Remembers a processed link.
     *
     * @param $provider
     * @param $url
     */
    protected function rememberRepresentation($provider, $url)
    {
        $fontAwesomeVersion = config('laravel-share.fontAwesomeVersion', 5);

        $this->generatedRepresentation[$provider] = trans(
            "share-buttons::share-buttons-fontawesome-$fontAwesomeVersion.$provider",
            [
                'url' => $url,
                'class' => key_exists('class', $this->options) ? $this->options['class'] : '',
                'id' => key_exists('id', $this->options) ? $this->options['id'] : '',
                'title' => key_exists('title', $this->options) ? $this->options['title'] : '',
                'rel' => key_exists('rel', $this->options) ? $this->options['rel'] : '',
            ]);
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     * @throws \Error
     */
    public function __call($name, $arguments)
    {
        if (array_key_exists($name, $this->providers)) {
            $additions = [
                'title' => $this->title,
            ];

            $processedUrl = $this->providers[$name]->buildUrl(
                $this->url,
                array_merge($additions, $this->normalizeArguments($arguments))
            );
            $this->buildLink($name, $processedUrl);

            return $this;
        }

        throw new \Error('Call to undefined method ' . $this->getShortClassName($this) . '::' . $name . '()');
    }

    /**
     * @param object $object
     * @return string
     */
    private function getShortClassName(object $object): string
    {
        $parsed = explode('\\', get_class($object));

        return end($parsed);
    }

    /**
     * @param array $arguments
     * @return array
     */
    private function normalizeArguments(array $arguments): array
    {
        if (empty($arguments) || !isset($arguments[0])) {
            return [];
        }

        if (is_string($arguments[0])) {
            return ['title' => $arguments[0]];
        }

        if (is_array($arguments[0])) {
            return $arguments[0];
        }

        return [];
    }

    /**
     * Return a string with generated HTML code.
     *
     * @return string
     */
    public function __toString()
    {
        $representation = '';

        $representation .= $this->options['prefix'];
        foreach ($this->generatedRepresentation as $link) {
            $representation .= $link;
        }
        $representation .= $this->options['suffix'];

        return $representation;
    }
}
