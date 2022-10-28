<?php

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

    /**
     * @param array $replacements
     * @return array
     */
    protected function prepareReplacements(array $replacements): array
    {
        $prepared = [];

        foreach ($replacements as $search => $replacement) {
            $prepared[':' . mb_strtolower($search)] = $replacement;
            $prepared[':' . mb_strtoupper($search)] = $replacement;
        }

        return $prepared;
    }
}
