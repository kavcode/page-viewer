<?php

declare(strict_types=1);

namespace App\Markdown;

class Parser
{
    /**
     * @var LineWalkerInterface[]
     */
    private array $lineWalkers = [];

    /**
     * @var BlockCollectionWalkerInterface[]
     */
    private array $blockWalkers = [];

    public function __construct(
        private readonly BlocksExtractor $blocksExtractor,
        private readonly WordSplitter $wordSplitter,
        private readonly HtmlWriter $htmlWriter
    ) {
    }

    public function addLineWalker(LineWalkerInterface $lineWalker): void
    {
        $this->lineWalkers[] = $lineWalker;
    }

    public function addBlockCollectionWalker(BlockCollectionWalkerInterface $blockCollectionWalker): void
    {
        $this->blockWalkers[] = $blockCollectionWalker;
    }

    public function parseFromLineArray(array $lines): ParseResult
    {
        $blocks = $this->blocksExtractor->extract($lines);
        foreach ($blocks as $block) {
        /** @var Block $blcok */
            $processedLines = [];
            foreach ($block->getLines() as $line) {
                $words = $this->wordSplitter->splitOnWordsAndMarks($line);
                foreach ($this->lineWalkers as $walker) {
                    $words = $walker->walk($words);
                }

                $processedLines[] = $this->wordSplitter->collectLine($words);
            }
            $block->updateLines($processedLines);
        }

        foreach ($this->blockWalkers as $walker) {
            $blocks = $walker->walk($blocks);
        }

        $title = '';
        foreach ($blocks as $block) {
            if ($block->getType() === BlockTypeInterface::HEADER) {
                $title = implode("\n", $block->getLines());
            }
        }

        return new ParseResult($title, $this->htmlWriter->write($blocks));
    }
}
