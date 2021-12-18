<?php

namespace Kudashevs\ShareButtons\Replacers;

class ColonReplacer implements Replacer
{
    /**
     * @inheritDoc
     */
    public function replace(string $line, array $replacements): string
    {
        $prepared = [];

        foreach ($replacements as $pattern => $replacement) {
            $prepared[':' . mb_strtolower($pattern)] = $replacement;
        }

        return strtr($line, $prepared);
    }
}
