<?php

declare(strict_types=1);

namespace App\Markdown;

class ParseResult
{
    public function __construct(
        private readonly string $title,
        private readonly string $html
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getHtml(): string
    {
        return $this->html;
    }
}
