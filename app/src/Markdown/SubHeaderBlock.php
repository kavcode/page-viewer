<?php

declare(strict_types=1);

namespace App\Markdown;

class SubHeaderBlock extends Block
{
    private $level;
    public function __construct(int $type, array $lines, int $level)
    {
        parent::__construct($type, $lines);
        $this->level = $level;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function toHtml(): string
    {
        return "<h{$this->level}>" . implode("\n", $this->getLines()) . "</h{$this->level}>";
    }
}
