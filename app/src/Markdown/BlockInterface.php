<?php declare(strict_types=1);

namespace App\Markdown;

interface BlockInterface
{
    public function getType(): int;

    public function updateBlocType(int $type): void;

    public function getLines(): array;

    public function updateLines(array $lines): void;

    public function addLine(string $line): void;

    public function addChild(Block $block): void;

    public function hasChildren(): bool;

    public function getChildren(): array;
}