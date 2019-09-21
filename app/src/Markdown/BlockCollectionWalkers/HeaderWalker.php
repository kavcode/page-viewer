<?php declare(strict_types=1);

namespace App\Markdown\BlockCollectionWalkers;

use App\Markdown\Block;
use App\Markdown\BlockCollectionWalkerInterface;
use App\Markdown\BlockTypeInterface;

class HeaderWalker implements BlockCollectionWalkerInterface
{
    public function walk(array $collection): array
    {
        $result = [];
        foreach ($collection as $block) {
            /** @var Block $block */
            $lines = $block->getLines();
            $linesCount = count($lines);
            if ($linesCount >= 2
                && preg_match('/^([-]+|[=]+)\s*$/m', $lines[$linesCount - 1])) {
                array_pop($lines);
                $result[] = new Block(BlockTypeInterface::HEADER, $lines);
                continue;
            }

            $result[] = $block;
        }
        return $result;
    }
}