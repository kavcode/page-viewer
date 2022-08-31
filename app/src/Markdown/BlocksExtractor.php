<?php

declare(strict_types=1);

namespace App\Markdown;

use PHPUnit\Framework\StaticAnalysis\HappyPath\AssertNotInstanceOf\B;

class BlocksExtractor
{
    /**
     * @param string[] $lines
     * @return Block[]
     */
    public function extract(array $lines): array
    {
        $blocks = [];
        $currentBlock = null;
        $isPrevLineEmpty = true;
        foreach ($lines as $line) {
            if (!$line || preg_match('/^\s+$/', $line)) {
                if (!$isPrevLineEmpty) {
                    $blocks[] = $currentBlock;
                    $currentBlock = null;
                }

                $isPrevLineEmpty = true;
                continue;
            }

            if ($isPrevLineEmpty) {
                $type = preg_match('/^\*/', $line) ? BlockTypeInterface::LIST_ITEM : BlockTypeInterface::PARAGRAPH;
                $line = $type === BlockTypeInterface::LIST_ITEM ? substr($line, 1) : $line;
                $currentBlock = new Block($type, [$line]);
                $isPrevLineEmpty = false;
                continue;
            }

            if (preg_match('/^\*/', $line)) {
                $blocks[] = $currentBlock;
                $currentBlock = new Block(BlockTypeInterface::LIST_ITEM, [substr($line, 1)]);
                continue;
            }

            $currentBlock->addLine($line);
            $isPrevLineEmpty = false;
        }

        if ($currentBlock) {
            $blocks[] = $currentBlock;
        }

        return $blocks;
    }
}
