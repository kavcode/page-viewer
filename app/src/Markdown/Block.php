<?php

declare(strict_types=1);

namespace App\Markdown;

class Block implements BlockInterface
{
    private int $type;

    /**
     * @var string[]
     */
    private array $lines;

    /**
     * @var Block[]
     */
    private array $children = [];

    /**
     * @param int $type
     * @param string[] $lines
     */
    public function __construct(int $type, array $lines = [])
    {
        $this->type = $type;
        $this->lines = $lines;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function updateBlocType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * @param string[] $lines
     * @return void
     */
    public function updateLines(array $lines): void
    {
        $this->lines = $lines;
    }

    public function addLine(string $line): void
    {
        $this->lines[] = $line;
    }

    public function addChild(Block $block): void
    {
        $this->children[] = $block;
    }

    public function hasChildren(): bool
    {
        return (bool) count($this->children);
    }

    /**
     * @return Block[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }
}
