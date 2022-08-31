<?php

declare(strict_types=1);

namespace App\Markdown;

interface LineWalkerInterface
{
    /**
     * @param string[] $words
     * @return string[]
     */
    public function walk(array $words): array;
}
