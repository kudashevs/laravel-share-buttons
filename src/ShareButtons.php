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

        $this->formatter->updateOptions($options);

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
        $this->generatedRepresentation[$provider] = $this->formatter->generateUrl($provider, $url, []);
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
     * Return a string with generated HTML code.
     *
     * @return string
     */
    public function __toString()
    {
        $representation = '';

        $representation .= $this->formatter->getOptions()['block_prefix'];
        foreach ($this->generatedRepresentation as $link) {
            $representation .= $link;
        }
        $representation .= $this->formatter->getOptions()['block_suffix'];

        return $representation;
    }
}
