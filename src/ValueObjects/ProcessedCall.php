<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\ValueObjects;

use Kudashevs\ShareButtons\Exceptions\InvalidProcessedCallArgument;
use Kudashevs\ShareButtons\ShareProviders\ShareProvider;

final class ProcessedCall
{
    private string $name;

    private ShareProvider $provider;

    private array $arguments;

    /**
     * @param string $name
     * @param ShareProvider $instance
     * @param array<string, string> $arguments
     *
     * @throws InvalidProcessedCallArgument
     */
    public function __construct(string $name, ShareProvider $instance, array $arguments)
    {
        $this->initName($name);
        $this->initProvider($instance);
        $this->initArguments($arguments);
    }

    private function initName(string $name): void
    {
        if (trim($name) === '') {
            throw new InvalidProcessedCallArgument('A name argument cannot be empty.');
        }

        $this->name = $name;
    }

    private function initProvider(ShareProvider $provider): void
    {
        $this->provider = $provider;
    }

    /**
     * @param array<string, string> $arguments
     */
    private function initArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ShareProvider
     */
    public function getProvider(): ShareProvider
    {
        return $this->provider;
    }

    /**
     * @return array<string, string>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
