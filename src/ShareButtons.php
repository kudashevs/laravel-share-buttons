<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons;

use BadMethodCallException;
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
    protected string $page;

    /**
     * Optional text for Twitter and Linkedin title.
     */
    protected string $title;

    protected Formatter $formatter;

    /**
     * Extra runtime options.
     */
    protected array $options = [
        'reactOnErrors' => false,
        'throwException' => BadMethodCallException::class,
    ];

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
    }

    /**
     * @param array $options
     */
    protected function initOptions(array $options = []): void
    {
        $applicable = $this->retrieveApplicableOptions($options);

        $this->options = array_merge($this->options, $applicable);
    }

    /**
     * @return array<string, bool|string>
     */
    protected function retrieveApplicableOptions(array $options): array
    {
        return array_filter($options, function ($option, $name) {
            return isset($this->options[$name]) &&
                gettype($this->options[$name]) === gettype($option);
        }, ARRAY_FILTER_USE_BOTH);
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

        $this->page = $url;
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
            $preparedArguments = $this->retrieveArguments($arguments);

            $provider = ShareProviderFactory::createFromName($name);

            $url = $provider->buildUrl(
                $this->page,
                $this->title,
                $preparedArguments
            );

            $this->rememberProcessedCalls($name, $url, $preparedArguments);

            return $this;
        }

        return $this->handleUnexpectedCall($name);
    }

    protected function isRegisteredProvider(string $name): bool
    {
        return ShareProviderFactory::isValidProviderName($name);
    }

    /**
     * @return array<string, string>
     */
    protected function retrieveArguments(array $arguments): array
    {
        if ($this->isAnyArgumentsProvided($arguments)) {
            return array_filter($arguments[0], 'is_string');
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
        /**
         * Since a share provider button can be displayed only once, there is no need to keep track and
         * make sure that the information about a previous provider's call might be overwritten.
         */
        $this->calls[$provider] = new ProcessedCall($provider, $url, $options);
    }

    protected function handleUnexpectedCall(string $name): ShareButtons
    {
        if ($this->options['reactOnErrors'] === true) {
            $exception = $this->retrieveUnexpectedCallException();

            throw new $exception(
                sprintf('Call to undefined method %s::%s().', $this->getShortClassName(), $name)
            );
        }

        return $this;
    }

    protected function retrieveUnexpectedCallException(): string
    {
        return class_exists($this->options['throwException'])
            ? $this->options['throwException']
            : BadMethodCallException::class;
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
