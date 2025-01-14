<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons;

use BadMethodCallException;
use Kudashevs\ShareButtons\Exceptions\InvalidOptionValue;
use Kudashevs\ShareButtons\Presenters\ShareButtonsPresenter;
use Kudashevs\ShareButtons\Presenters\TemplateBasedPresenterMediator;
use Kudashevs\ShareButtons\ValueObjects\ProcessedCall;

/**
 * @todo don't forget to update these method signatures
 *
 * @method ShareButtons bluesky(array $options = [])
 * @method ShareButtons copylink(array $options = [])
 * @method ShareButtons evernote(array $options = [])
 * @method ShareButtons facebook(array $options = [])
 * @method ShareButtons hackernews(array $options = [])
 * @method ShareButtons linkedin(array $options = [])
 * @method ShareButtons mailto(array $options = [])
 * @method ShareButtons mastodon(array $options = [])
 * @method ShareButtons pinterest(array $options = [])
 * @method ShareButtons pocket(array $options = [])
 * @method ShareButtons reddit(array $options = [])
 * @method ShareButtons skype(array $options = [])
 * @method ShareButtons telegram(array $options = [])
 * @method ShareButtons tumblr(array $options = [])
 * @method ShareButtons twitter(array $options = [])
 * @method ShareButtons vkontakte(array $options = [])
 * @method ShareButtons whatsapp(array $options = [])
 * @method ShareButtons xing(array $options = [])
 */
class ShareButtons implements \Stringable
{
    protected ShareButtonsPresenter $presenter;

    /**
     * A URL of the page to share.
     */
    protected string $pageUrl;

    /**
     * A title of the page to share.
     */
    protected string $pageTitle;

    /**
     * Contain processed calls.
     *
     * @var array<string, ProcessedCall>
     */
    protected array $calls = [];

    /**
     * @param array{templater?: class-string, url_templater?: class-string} $options
     *
     * @throws InvalidOptionValue
     */
    public function __construct(array $options = [])
    {
        $this->initPresenter($options);
    }

    /**
     * @param array{templater?: class-string, url_templater?: class-string} $options
     *
     * @throws InvalidOptionValue
     */
    protected function initPresenter(array $options): void
    {
        $this->presenter = $this->createPresenter($options);
    }

    /**
     * @param array{templater?: class-string, url_templater?: class-string} $options
     *
     * @throws InvalidOptionValue
     */
    protected function createPresenter(array $options): ShareButtonsPresenter
    {
        return new TemplateBasedPresenterMediator($options);
    }

    /**
     * @param string $url
     * @param string $title
     * @param array{block_prefix?: string, block_suffix?: string, element_prefix?: string, element_suffix?: string, id?: string, class?: string, title?: string, rel?: string} $options
     * @return $this
     */
    public function page(string $url, string $title = '', array $options = []): static
    {
        $this->refreshState($options);

        $this->pageUrl = $url;
        $this->pageTitle = $title;

        return $this;
    }

    /**
     * Refresh state and delete all previously remembered calls.
     *
     * @param array{block_prefix?: string, block_suffix?: string, element_prefix?: string, element_suffix?: string, id?: string, class?: string, title?: string, rel?: string} $options
     */
    protected function refreshState(array $options): void
    {
        $this->presenter->refresh($options);
        $this->calls = [];
    }

    /**
     * @param string $title
     * @param array{block_prefix?: string, block_suffix?: string, element_prefix?: string, element_suffix?: string, id?: string, class?: string, title?: string, rel?: string} $options
     * @return $this
     */
    public function currentPage(string $title = '', array $options = []): static
    {
        $url = app('request')->url();

        return $this->page($url, $title, $options);
    }

    /**
     * @param string $url
     * @param string $title
     * @param array{block_prefix?: string, block_suffix?: string, element_prefix?: string, element_suffix?: string, id?: string, class?: string, title?: string, rel?: string} $options
     * @return $this
     */
    public function createForPage(string $url, string $title = '', array $options = []): static
    {
        return $this->page($url, $title, $options);
    }

    /**
     * @param string $title
     * @param array{block_prefix?: string, block_suffix?: string, element_prefix?: string, element_suffix?: string, id?: string, class?: string, title?: string, rel?: string} $options
     * @return $this
     */
    public function createForCurrentPage(string $title = '', array $options = []): static
    {
        return $this->currentPage($title, $options);
    }

    /**
     * @param string $name
     * @param array<array-key, array<string, string>> $arguments
     * @return mixed|ShareButtons
     *
     * @throws BadMethodCallException
     */
    public function __call(string $name, array $arguments): mixed
    {
        if ($this->isExpectedCall($name)) {
            $applicableArguments = $this->retrieveCallArguments($arguments);
            $prioritizedArguments = $this->prioritizeArguments($applicableArguments);

            $this->rememberProcessedCall($name, $prioritizedArguments);
        } else {
            $this->handleUnexpectedCall($name);
        }

        return $this;
    }

    protected function isExpectedCall(string $name): bool
    {
        return config()->has('share-buttons.buttons.' . $name)
            && config()->has('share-buttons.templates.' . $name);
    }

    /**
     * @param array<array-key, array<string, string>> $arguments
     * @return array{text?: string, id?: string, class?: string, title?: string, rel?: string, summary?: string}
     */
    protected function retrieveCallArguments(array $arguments): array
    {
        if ($this->isAnyApplicableCallArguments($arguments)) {
            return array_filter($arguments[0], 'is_string');
        }

        return [];
    }

    /**
     * @param array<array-key, array<string, string>> $arguments
     */
    protected function isAnyApplicableCallArguments(array $arguments): bool
    {
        return isset($arguments[0]) && is_array($arguments[0]);
    }

    /**
     * @param array{text?: string, id?: string, class?: string, title?: string, rel?: string, summary?: string} $arguments
     * @return array{url: string, text: string, id?: string, class?: string, title?: string, rel?: string, summary?: string}
     */
    protected function prioritizeArguments(array $arguments): array
    {
        $lowPriorityArguments = [
            'text' => $this->pageTitle,
        ];

        $highPriorityArguments = [
            'url' => $this->pageUrl,
        ];

        return array_merge(
            $lowPriorityArguments,
            $arguments,
            $highPriorityArguments,
        );
    }

    /**
     * @param array{url: string, text: string, id?: string, class?: string, title?: string, rel?: string, summary?: string} $arguments
     */
    protected function rememberProcessedCall(string $name, array $arguments): void
    {
        // Since a share button can be displayed only once, there is no need to keep track and
        // make sure that the information about a previous button's call might be overwritten.
        $this->calls[$name] = new ProcessedCall($name, $arguments);
    }

    /**
     * @throws BadMethodCallException
     */
    protected function handleUnexpectedCall(string $name): void
    {
        throw new BadMethodCallException(
            sprintf('Call to undefined method %s::%s().', static::class, $name)
        );
    }

    /**
     * Return a generated share buttons HTML code.
     *
     * @return string
     */
    public function render(): string
    {
        return $this->generateShareButtons();
    }

    /**
     * Return a generated share buttons HTML code.
     *
     * @return string
     */
    public function getShareButtons(): string
    {
        return $this->generateShareButtons();
    }

    /**
     * Return a generated share buttons HTML code.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->generateShareButtons();
    }

    protected function generateShareButtons(): string
    {
        $representation = $this->presenter->getBlockPrefix();

        /** @var ProcessedCall $call */
        foreach ($this->calls as $call) {
            $representation .= $this->presenter->getElementPrefix();
            $representation .= $this->presenter->getElementBody(
                $call->getName(),
                $call->getArguments(),
            );
            $representation .= $this->presenter->getElementSuffix();
        }

        $representation .= $this->presenter->getBlockSuffix();

        return $representation;
    }

    /**
     * Return generated raw links.
     *
     * @return array<string, string>
     */
    public function getRawLinks(): array
    {
        return array_map(function ($call) {
            return $this->presenter->getElementUrl(
                $call->getName(),
                $call->getArguments(),
            );
        }, $this->calls);
    }
}
