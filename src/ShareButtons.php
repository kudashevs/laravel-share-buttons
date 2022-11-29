<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons;

use BadMethodCallException;
use Kudashevs\ShareButtons\Presenters\ShareButtonsPresenter;
use Kudashevs\ShareButtons\Presenters\TemplateShareButtonsPresenter;
use Kudashevs\ShareButtons\UrlProviders\TemplateUrlProvider;
use Kudashevs\ShareButtons\UrlProviders\UrlProvider;
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
    protected ShareButtonsPresenter $presenter;

    protected UrlProvider $provider;

    /**
     * The url of a page to share.
     */
    protected string $page;

    /**
     * Optional text for some share providers.
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
     * Contain processed calls.
     */
    protected array $calls = [];

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->initPresenter($options);
        $this->initUrlProvider($options);

        $this->initOptions($options);
    }

    protected function initPresenter(array $options): void
    {
        $this->presenter = $this->createPresenter($options);
    }

    protected function createPresenter(array $options): ShareButtonsPresenter
    {
        return new TemplateShareButtonsPresenter($options);
    }

    protected function initUrlProvider(array $options): void
    {
        $this->provider = $this->createUrlProvider($options);
    }

    protected function createUrlProvider(array $options): UrlProvider
    {
        return new TemplateUrlProvider($options);
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
        $this->presenter->refreshRepresentation($options);
        $this->clearState();

        $this->page = $url;
        $this->title = $title;

        return $this;
    }

    /**
     * Clear state (delete all previously remembered processed calls).
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
     * @return ShareButtons
     *
     * @throws BadMethodCallException
     */
    public function __call(string $name, array $arguments)
    {
        $applicableArguments = $this->prepareApplicableArguments($arguments);
        $this->rememberProcessedCall($name, $applicableArguments);

        return $this;
    }

    /**
     * @param array<string, mixed> $arguments
     * @return array<string, string>
     */
    protected function prepareApplicableArguments(array $arguments): array
    {
        $initial = [
            'url' => $this->page,
            'text' => $this->title,
        ];

        $applicable = $this->retrieveApplicableArguments($arguments);

        return array_merge($applicable, $initial);
    }

    /**
     * @return array<string, string>
     */
    protected function retrieveApplicableArguments(array $arguments): array
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

    protected function rememberProcessedCall(string $name, array $arguments = []): void
    {
        /**
         * Since a share provider button can be displayed only once, there is no need to keep track and
         * make sure that the information about a previous provider's call might be overwritten.
         */
        $this->calls[$name] = new ProcessedCall($name, $arguments);
    }

    protected function handleUnexpectedCall(string $name): void
    {
        if ($this->options['reactOnErrors'] === true) {
            $exception = $this->retrieveUnexpectedCallException();

            throw new $exception(
                sprintf('Call to undefined method %s::%s().', __CLASS__, $name)
            );
        }
    }

    protected function retrieveUnexpectedCallException(): string
    {
        return class_exists($this->options['throwException'])
            ? $this->options['throwException']
            : BadMethodCallException::class;
    }

    /**
     * Return generated raw links.
     *
     * @return array
     */
    public function getRawLinks(): array
    {
        $links = array_map(function ($call) {
            return $this->retrieveUrlFromProcessedCall(
                $call->getName(),
                $call->getArguments(),
            );
        }, $this->calls);

        return array_filter($links, 'strlen');
    }

    protected function retrieveUrlFromProcessedCall(string $name, array $arguments): string
    {
        $url = $this->provider->generateUrl(
            $name,
            $arguments
        );

        if (trim($url) === '') {
            $this->handleUnexpectedCall($name);
        }

        return $url;
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

        /** @var ProcessedCall $call */
        foreach ($this->calls as $call) {
            $url = $this->retrieveUrlFromProcessedCall($call->getName(), $call->getArguments());

            $representation .= $this->presenter->getElementPrefix();
            $representation .= $this->presenter->getElementBody(
                $call->getName(),
                $url,
                $call->getArguments(),
            );
            $representation .= $this->presenter->getElementSuffix();
        }

        $representation .= $this->presenter->getBlockSuffix();

        return $representation;
    }
}
