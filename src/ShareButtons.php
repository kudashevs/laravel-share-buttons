<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons;

use BadMethodCallException;
use Kudashevs\ShareButtons\Factories\ShareProviderFactory;
use Kudashevs\ShareButtons\Presenters\ShareButtonsPresenter;
use Kudashevs\ShareButtons\Presenters\TemplatingShareButtonsPresenter;
use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

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
    protected ShareButtonsPresenter $presenter;

    /**
     * The url of a page to share.
     */
    protected string $page;

    /**
     * Optional text for Twitter and Linkedin title.
     */
    protected string $title;

    /**
     * Extra runtime options.
     */
    protected array $options = [
        'reactOnErrors' => false,
        'throwException' => BadMethodCallException::class,
    ];

    /**
     * Contain processed share providers.
     */
    protected array $providers = [];

    /**
     * @param ShareButtonsPresenter $formatter
     * @param array $options
     */
    public function __construct(ShareButtonsPresenter $formatter, array $options = [])
    {
        $this->initPresenter($options);
        $this->initOptions($options);
    }

    protected function initPresenter(array $options): void
    {
        $this->presenter = $this->createPresenter($options);
    }

    protected function createPresenter(array $options): ShareButtonsPresenter
    {
        return new TemplatingShareButtonsPresenter($options);
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

        $this->presenter->refreshStyling($options);

        return $this;
    }

    /**
     * Clear the state of a previous call.
     */
    protected function clearState(): void
    {
        $this->providers = [];
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
     *
     * @throws BadMethodCallException
     */
    public function __call(string $name, array $arguments)
    {
        if ($this->isRegisteredProvider($name)) {
            $preparedArguments = $this->retrieveArguments($arguments);

            $provider = ShareProviderFactory::createFromMethodCall(
                $name,
                $this->page,
                $this->title,
                $preparedArguments,
            );

            $this->rememberProcessedProvider($provider);

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
     * Remember a processed share provider.
     *
     * @param ShareProvider $provider
     * @return void
     */
    protected function rememberProcessedProvider(ShareProvider $provider): void
    {
        /**
         * Since a share provider button can be displayed only once, there is no need to keep track and
         * make sure that the information about a previous provider's call might be overwritten.
         */
        $this->providers[$provider->getName()] = $provider;
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
        return array_map(static function ($provider) {
            return $provider->getUrl();
        }, $this->providers);
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
        $representation = $this->presenter->getBlockPrefix();

        /** @var ShareProvider $provider */
        foreach ($this->providers as $provider) {
            $representation .= $this->presenter->getElementPrefix();
            $representation .= $this->presenter->getElementBody($provider);
            $representation .= $this->presenter->getElementSuffix();
        }

        $representation .= $this->presenter->getBlockSuffix();

        return $representation;
    }
}
