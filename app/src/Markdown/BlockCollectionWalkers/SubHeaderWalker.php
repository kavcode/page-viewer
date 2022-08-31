<?php

declare(strict_types=1);

namespace App\Markdown\BlockCollectionWalkers;

use App\Markdown\Block;
use App\Markdown\BlockCollectionWalkerInterface;
use App\Markdown\BlockTypeInterface;
use App\Markdown\SubHeaderBlock;

class SubHeaderWalker implements BlockCollectionWalkerInterface
{
    public function walk(array $collection): array
    {
        $result = [];
        foreach ($collection as $block) {
        /** @var Block $block */
            $lines = $block->getLines();
            if (preg_match('/^(#+)[^#](.*)$/', $lines[0], $match)) {
                $level = strlen($match[1]);
                if ($level > 1 && $level < 7) {
                    $lines[0] = $match[2];
                    if (trim($match[2])) {
                        $result[] = new SubHeaderBlock(BlockTypeInterface::SUBHEADER, $lines, $level);
                        continue;
                    }
                }
            }

            $result[] = $block;
        }
        return $result;
    }
}
