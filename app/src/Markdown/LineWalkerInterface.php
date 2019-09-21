<?php declare(strict_types=1);

namespace App\Markdown;

interface LineWalkerInterface
{
    public function walk(array $words): array;
}