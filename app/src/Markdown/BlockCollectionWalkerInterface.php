<?php

declare(strict_types=1);

namespace App\Markdown;

interface BlockCollectionWalkerInterface
{
    /**
     * @param array<int, Block> $collection
     * @return array<int, Block>
     */
    public function walk(array $collection): array;
}
