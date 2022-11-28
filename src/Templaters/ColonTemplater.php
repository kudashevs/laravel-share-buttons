<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Templaters;

class ColonTemplater implements Templater
{
    /**
     * @inheritDoc
     */
    public function process(string $template, array $replacements): string
    {
        $prepared = $this->prepareReplacements($replacements);

        return strtr($template, $prepared);
    }

    protected function prepareReplacements(array $replacements): array
    {
        $prepared = [];

        foreach ($replacements as $search => $replace) {
            $prepared[':' . mb_strtolower($search)] = $replace;
            $prepared[':' . mb_strtoupper($search)] = mb_strtoupper($replace);
        }

        return $prepared;
    }
}
