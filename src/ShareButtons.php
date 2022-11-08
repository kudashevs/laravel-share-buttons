<?php

namespace Kudashevs\ShareButtons;

use Kudashevs\ShareButtons\Formatters\Formatter;
use Kudashevs\ShareButtons\ShareProviders\ShareProviderFactory;
use Kudashevs\ShareButtons\ValueObjects\ProcessedCall;

/**
 * @todo don't forget to update these method signatures
 *
 * @method ShareButtons copylink(array $options = [])
 * @method ShareButtons evernote(array $options = [])
 * @method ShareButtons facebook(array $options = [])
 * @method ShareButtons hackernews(array $options = [])
 * @method ShareButtons linkedin(array $options = [])
 * @method ShareButtons mailto(array $options = [])
 * @method ShareButtons pinterest(array $options = [])
 * @method ShareButtons pocket(array $options = [])
 * @method ShareButtons reddit(array $options = [])
 * @method ShareButtons skype(array $options = [])
 * @method ShareButtons telegram(array $options = [])
 * @method ShareButtons twitter(array $options = [])
 * @method ShareButtons vkontakte(array $options = [])
 * @method ShareButtons whatsapp(array $options = [])
 * @method ShareButtons xing(array $options = [])
 */
class ShareButtons
{
    /**
     * The url of a page to share.
     */
    protected string $url;

    /**
     * Optional text for Twitter and Linkedin title.
     */
    protected string $title;

    protected Formatter $formatter;

    /**
     * Extra options for the share links.
     */
    protected array $options = [
        'reactOnErrors' => null,
        'throwException' => null,
    ];

    /**
     * Contain share providers instances.
     */
    protected array $providers = [];

    /**
     * Contain processed calls.
     */
    protected array $calls = [];

    /**
     * Share constructor.
     *
     * @param Formatter $formatter
     * @param array $options
     */
    public function __construct(Formatter $formatter, array $options = [])
    {
        $this->initOptions($options);

        $this->formatter = $formatter;
        $this->formatter->updateOptions($options);

        /**
         * We want to initialize providers here and keep them to be sure
         * that we won't fail in runtime because of a wrong initialization.
         */
        $this->initProviders();
    }

    /**
     * @param array $options
     */
    protected function initOptions(array $options = []): void
    {
        $allowed = array_intersect_key($options, $this->options);

        $this->options = array_merge($this->options, $allowed);
    }

    /**
     * Initialize share providers.
     *
     * @return void
     */
    protected function initProviders(): void
    {
        $this->providers = ShareProviderFactory::createAll();
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
    protected function clearState(): void
    {
        $this->calls = [];
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
     * @param string $url
     * @param string $title
     * @param array $options
     * @return $this
     */
    public function createForPage(string $url, string $title = '', array $options = []): self
    {
        return $this->page($url, $title, $options);
    }

    /**
     * @param string $title
     * @param array $options
     * @return $this
     */
    public function createForCurrentPage(string $title = '', array $options = []): self
    {
        return $this->currentPage($title, $options);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return $this
     * @throws \Error
     */
    public function __call(string $name, array $arguments)
    {
        if ($this->isRegisteredProvider($name)) {
            $normalizedArguments = $this->normalizeArguments($arguments);

            $url = $this->providers[$name]->buildUrl(
                $this->url,
                $this->title,
                $normalizedArguments
            );

            $this->rememberProcessedCalls($name, $url, $normalizedArguments);

            return $this;
        }

        return $this->handleUnexpectedCall($name);
    }

    protected function isRegisteredProvider(string $name): bool
    {
        return array_key_exists($name, $this->providers);
    }

    /**
     * @param array $arguments
     * @return array
     */
    protected function normalizeArguments(array $arguments): array
    {
        if ($this->isAnyArgumentsProvided($arguments)) {
            return $arguments[0];
        }

        return [];
    }

    protected function isAnyArgumentsProvided(array $arguments): bool
    {
        return isset($arguments[0]) && is_array($arguments[0]);
    }

    /**
     * Remember processed calls.
     *
     * @param string $provider
     * @param string $url
     * @param array $options
     */
    protected function rememberProcessedCalls(string $provider, string $url, array $options = []): void
    {
        $this->calls[$provider] = new ProcessedCall($provider, $url, $options);
    }

    protected function handleUnexpectedCall(string $name): ShareButtons
    {
        if ($this->options['reactOnErrors'] === true) {
            $exception = $this->prepareException();

            throw new $exception(
                sprintf('Call to undefined method %s::%s().', $this->getShortClassName(), $name)
            );
        }

        return $this;
    }

    protected function prepareException(): string
    {
        if (($exception = $this->options['throwException']) && class_exists($exception)) {
            return $exception;
        }

        return \Error::class;
    }

    /**
     * @return string
     */
    protected function getShortClassName(): string
    {
        $parsed = explode('\\', get_class($this));

        return end($parsed);
    }

    /**
     * Return generated raw links.
     *
     * @return array
     */
    public function getRawLinks(): array
    {
        return array_map(static function ($call) {
            return $call->getUrl();
        }, $this->calls);
    }

    /**
     * Return the prepared share buttons HTML code.
     *
     * @return string
     */
    public function getShareButtons(): string
    {
        return $this->generateShareButtons();
    }

    /**
     * Return a string with generated HTML code.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->generateShareButtons();
    }

    protected function generateShareButtons(): string
    {
        $representation = $this->formatter->getBlockPrefix();

        /** @var ProcessedCall $call */
        foreach ($this->calls as $call) {
            $representation .= $this->formatter->getElementPrefix();
            $representation .= $this->formatter->formatElement(
                $call->getProvider(),
                $call->getUrl(),
                $call->getOptions()
            );
            $representation .= $this->formatter->getElementSuffix();
        }

        $representation .= $this->formatter->getBlockSuffix();

        return $representation;
    }
}
