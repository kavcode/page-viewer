<?php

declare(strict_types=1);

namespace App\Domain\Documents;

class Document
{
    private $title;
    private $link;
    private $content;
    public function __construct(string $title, string $link, string $content)
    {
        $this->title = $title;
        $this->link = $link;
        $this->content = $content;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
