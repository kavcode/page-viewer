<?php declare(strict_types=1);

namespace App\Markdown\BlockCollectionWalkers;

use App\Markdown\Block;
use App\Markdown\BlockCollectionWalkerInterface;
use App\Markdown\BlockTypeInterface;

class UnorderedListWalker implements BlockCollectionWalkerInterface
{
    public function walk(array $collection): array
    {
        $result = [];
        $lastKey = null;
        foreach ($collection as $k => $block) {
            /** @var Block $block */
            if ($block->getType() === BlockTypeInterface::LIST_ITEM) {

                if (!$lastKey) {
                    $result[$k] = new Block(BlockTypeInterface::UNORDERED_LIST);
                    $result[$k]->addChild($block);
                    $lastKey = $k;
                    continue;
                }

                if ($result[$lastKey]->getType() !== BlockTypeInterface::UNORDERED_LIST) {

                    if ($k - 1 !== $lastKey) {
                        $k = $lastKey + 1;
                    }

                    $result[$k] = new Block(BlockTypeInterface::UNORDERED_LIST);
                    $result[$k]->addChild($block);
                    $lastKey = $k;
                    continue;
                }

                if ($result[$lastKey]->getType() === BlockTypeInterface::UNORDERED_LIST) {
                    $result[$lastKey]->addChild($block);
                    continue;
                }
                throw new \LogicException('Something went wrong');
            }

            if ($lastKey && $k - 1 !== $lastKey) {
                $k = $lastKey + 1;
            }

            $result[$k] = $block;
            $lastKey = $k;
        }

        return $result;
    }
}