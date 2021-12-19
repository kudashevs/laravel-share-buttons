<?php

namespace Kudashevs\ShareButtons\Templater;

class ColonTemplater implements Templater
{
    /**
     * @inheritDoc
     */
    public function replace(string $line, array $replacements): string
    {
        $prepared = $this->prepareReplacements($replacements);

        return strtr($line, $prepared);
    }

    /**
     * @param array $replacements
     * @return array
     */
    private function prepareReplacements(array $replacements): array
    {
        $prepared = [];

        foreach ($replacements as $pattern => $replacement) {
            $prepared[':' . mb_strtolower($pattern)] = $replacement;
            $prepared[':' . mb_strtoupper($pattern)] = $replacement;
        }

        return $prepared;
    }
}
