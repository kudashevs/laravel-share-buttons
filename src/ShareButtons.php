<?php

namespace Kudashevs\ShareButtons;

use Kudashevs\ShareButtons\Formatters\Formatter;
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
     * @var Formatter
     */
    private $formatter;

    /**
     * Extra options for the share links.
     *
     * @var array
     */
    protected $options = [
        'prefix' => '<div id="social-links"><ul>',
        'suffix' => '</ul></div>',
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
    public function __construct(Formatter $formatter, array $options = [])
    {
        $this->formatter = $formatter;
        $this->formatter->updateOptions($options);

        $this->initProviders();
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
        $this->initMassOptions($options);

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

    private function initMassOptions(array $options): void
    {
        $massOptions = [
            'id' => '',
            'class' => '',
            'title' => '',
            'rel' => '',
        ];

        $allowed = array_intersect_key($options, $massOptions);
        $this->options = array_merge($this->options, $allowed);
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
     * @param $name
     * @param $arguments
     * @return $this
     * @throws \Error
     */
    public function __call($name, $arguments)
    {
        if (array_key_exists($name, $this->providers)) {

            $arguments = $this->prepareArguments($arguments);

            $url = $this->providers[$name]->buildUrl(
                $this->url,
                $arguments
            );

            $this->rememberProcessed($name, $url);

            return $this;

        }

        throw new \Error('Call to undefined method ' . $this->getShortClassName($this) . '::' . $name . '()');
    }

    /**
     * @param array $arguments
     * @return array
     */
    private function prepareArguments(array $arguments): array
    {
        $arguments = $this->normalizeArguments($arguments);
        $additions = $this->getArgumentsFromState();

        return array_merge($additions, $arguments);
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
     * @return array
     */
    private function getArgumentsFromState(): array
    {
        return [
            'title' => $this->title,
        ];
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
     * Build a single link.
     *
     * @param string $provider
     * @param string $url
     */
    protected function rememberProcessed($provider, $url): void
    {
        $this->rememberRawLink($provider, $url);

        $this->rememberRepresentation($provider, $url);
    }

    /**
     * Remembers a processed link.
     *
     * @param string $provider
     * @param string $link
     */
    protected function rememberRawLink($provider, $link): void
    {
        $this->generatedUrls[$provider] = $link;
    }

    /**
     * Remembers a processed link.
     *
     * @param $provider
     * @param $url
     */
    protected function rememberRepresentation($provider, $url): void
    {
        $fontAwesomeVersion = 5;

        $this->generatedRepresentation[$provider] = trans(
            "share-buttons::share-buttons-fontawesome-$fontAwesomeVersion.$provider",
            [
                'url' => $url,
                'class' => !empty($this->options['class']) ? $this->options['class'] : '',
                'id' => !empty($this->options['id']) ? $this->options['id'] : '',
                'title' => !empty($this->options['title']) ? $this->options['title'] : '',
                'rel' => !empty($this->options['rel']) ? $this->options['rel'] : '',
            ]);
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
