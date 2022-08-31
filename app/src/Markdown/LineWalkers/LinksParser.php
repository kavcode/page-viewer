<?php

declare(strict_types=1);

namespace App\Markdown\LineWalkers;

use App\Markdown\LineWalkerInterface;

class LinksParser implements LineWalkerInterface
{
    public function walk(array $words): array
    {
        $result = [];
        foreach ($words as $word) {
            if (filter_var($word, FILTER_VALIDATE_URL)) {
                $result[] = "<a href=\"{$word}\">{$word}</a>";
                continue;
            }
            $result[] = $word;
        }
        return $result;
    }
}
