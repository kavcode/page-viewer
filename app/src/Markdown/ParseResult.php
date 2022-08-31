<?php

declare(strict_types=1);

namespace App\Markdown;

class ParseResult
{
    private $title;
    private $html;
    public function __construct(string $title, string $html)
    {
        $this->title = $title;
        $this->html = $html;
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
