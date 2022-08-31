<?php

declare(strict_types=1);

namespace App\Markdown;

class Block implements BlockInterface
{
    private $type;
    private $lines;
    private $children = [];
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

    public function getLines(): array
    {
        return $this->lines;
    }

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

    public function getChildren(): array
    {
        return $this->children;
    }
}
