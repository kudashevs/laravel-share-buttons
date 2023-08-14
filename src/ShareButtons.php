<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons;

use BadMethodCallException;
use Kudashevs\ShareButtons\Presenters\ShareButtonsPresenter;
use Kudashevs\ShareButtons\Presenters\TemplateShareButtonsPresenter;
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

    /**
     * A URL of the page to share.
     */
    protected string $pageUrl;

    /**
     * A title of the page to share.
     */
    protected string $pageTitle;

    /**
     * Extra runtime options.
     *
     * @var array<string, string>
     */
    protected array $options = [];

    /**
     * Contain processed calls.
     *
     * @var array<string, ProcessedCall>
     */
    protected array $calls = [];

    /**
     * @param array<string, bool|string> $options
     */
    public function __construct(array $options = [])
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
        return new TemplateShareButtonsPresenter($options);
    }

    /**
     * @param array<string, bool|string> $options
     */
    protected function initOptions(array $options): void
    {
        $applicable = $this->retrieveApplicableOptions($options);

        $this->options = array_merge($this->options, $applicable);
    }

    /**
     * @return array<string, string>
     */
    protected function retrieveApplicableOptions(array $options): array
    {
        return array_filter($options, function ($option, $name) {
            return isset($this->options[$name]) && gettype($this->options[$name]) === gettype($option);
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * @param string $url
     * @param string $title
     * @param array<string, string> $options
     * @return $this
     */
    public function page(string $url, string $title = '', array $options = []): self
    {
        $this->refreshState($options);

        $this->pageUrl = $url;
        $this->pageTitle = $title;

        return $this;
    }

    /**
     * Refresh state and delete all previously remembered calls.
     */
    protected function refreshState(array $options): void
    {
        $this->presenter->refresh($options);
        $this->calls = [];
    }

    /**
     * @param string $title
     * @param array $options
     * @return $this
     */
    public function currentPage(string $title = '', array $options = []): self
    {
        $url = app('request')->url();

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
        if ($this->isExpectedCall($name)) {
            $applicableArguments = $this->prepareApplicableArguments($arguments);
            $this->rememberProcessedCall($name, $applicableArguments);
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
     * @param array<string, mixed> $arguments
     * @return array<string, string>
     */
    protected function prepareApplicableArguments(array $arguments): array
    {
        $applicable = $this->retrieveApplicableArguments($arguments);

        return array_merge($applicable, [
            'url' => $this->pageUrl,
            'text' => $this->pageTitle,
        ]);
    }

    /**
     * @return array<string, string>
     */
    protected function retrieveApplicableArguments(array $arguments): array
    {
        if ($this->isAnyApplicableArgumentsProvided($arguments)) {
            return array_filter($arguments[0], 'is_string');
        }

        return [];
    }

    protected function isAnyApplicableArgumentsProvided(array $arguments): bool
    {
        return isset($arguments[0]) && is_array($arguments[0]);
    }

    protected function rememberProcessedCall(string $name, array $arguments = []): void
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
    public function __toString()
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
     * @return array
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
