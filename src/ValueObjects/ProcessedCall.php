<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\ValueObjects;

use Kudashevs\ShareButtons\Exceptions\InvalidProcessedCallArgument;

final class ProcessedCall
{
    private string $name;

    /**
     * @var array{url: string, text: string, id?: string, class?: string, title?: string, rel?: string, summary?: string}
     */
    private array $arguments;

    /**
     * @param string $name
     * @param array{url: string, text: string, id?: string, class?: string, title?: string, rel?: string, summary?: string} $arguments
     *
     * @throws InvalidProcessedCallArgument
     */
    public function __construct(string $name, array $arguments)
    {
        $this->initName($name);
        $this->initArguments($arguments);
    }

    private function initName(string $name): void
    {
        if (trim($name) === '') {
            throw new InvalidProcessedCallArgument('A name argument cannot be empty.');
        }

        $this->name = $name;
    }

    /**
     * @param array{url: string, text: string, id?: string, class?: string, title?: string, rel?: string, summary?: string} $arguments
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
     * @return array{url: string, text: string, id?: string, class?: string, title?: string, rel?: string, summary?: string}
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
