<?php

declare(strict_types=1);

namespace App\Markdown;

interface BlockCollectionWalkerInterface
{
    /**
     * @param Block[] $collection
     * @return Block[]
     */
    public function walk(array $collection): array;
}
