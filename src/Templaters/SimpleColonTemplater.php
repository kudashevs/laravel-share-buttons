<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Templaters;

class SimpleColonTemplater implements Templater
{
    /**
     * {@inheritDoc}
     *
     * @param string $template
     * @param array<string, string> $replacements
     * @return string
     */
    public function process(string $template, array $replacements): string
    {
        $prepared = $this->prepareReplacements($replacements);

        return $this->applyReplacements($template, $prepared);
    }

    /**
     * @param array<string, string> $replacements
     * @return array<string, string>
     */
    protected function prepareReplacements(array $replacements): array
    {
        $prepared = [];

        foreach ($replacements as $search => $replace) {
            $prepared[':' . mb_strtolower($search)] = $replace;
            $prepared[':' . mb_strtoupper($search)] = mb_strtoupper($replace);
        }

        return $prepared;
    }

    /**
     * @param array<string, string> $replacements
     */
    protected function applyReplacements(string $template, array $replacements): string
    {
        return strtr($template, $replacements);
    }
}
