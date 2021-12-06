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
    protected $options = [];

    /**
     * An HTML code to prefix before the share links.
     *
     * @var string
     */
    protected $prefix = '<div id="social-links"><ul>';

    /**
     * An HTML code to append after the share links.
     *
     * @var string
     */
    protected $suffix = '</ul></div>';

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
    public function __construct()
    {
        $this->initProviders();
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
     * @param string|null $prefix
     * @param string|null $suffix
     * @return $this
     */
    public function page($url, $title = '', $options = [], $prefix = null, $suffix = null)
    {
        $this->clearState();

        $this->url = $url;
        $this->title = $title;
        $this->options = $options;

        $this->setPrefixAndSuffix($prefix, $suffix);

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
     * @param string|null $prefix
     * @param string|null $suffix
     * @return $this
     */
    public function currentPage($title = '', $options = [], $prefix = null, $suffix = null)
    {
        $url = request()->getUri();

        return $this->page($url, $title, $options, $prefix, $suffix);
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
            "laravel-share::laravel-share-fa$fontAwesomeVersion.$provider",
            [
                'url' => $url,
                'class' => key_exists('class', $this->options) ? $this->options['class'] : '',
                'id' => key_exists('id', $this->options) ? $this->options['id'] : '',
                'title' => key_exists('title', $this->options) ? $this->options['title'] : '',
                'rel' => key_exists('rel', $this->options) ? $this->options['rel'] : '',
            ]);
    }

    /**
     * Set custom prefix and/or suffix optionally.
     *
     * @param string $prefix
     * @param string $suffix
     */
    protected function setPrefixAndSuffix($prefix, $suffix)
    {
        if (!is_null($prefix)) {
            $this->prefix = $prefix;
        }

        if (!is_null($suffix)) {
            $this->suffix = $suffix;
        }
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     * @throws \Error
     * @throws \ReflectionException // todo eliminate this
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

        throw new \Error('Call to undefined method ' . (new \ReflectionClass($this))->getShortName() . '::' . $name . '()');
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

        $representation .= $this->prefix;
        foreach ($this->generatedRepresentation as $link) {
            $representation .= $link;
        }
        $representation .= $this->suffix;

        return $representation;
    }
}
