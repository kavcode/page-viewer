<?php

declare(strict_types=1);

namespace App\Domain\Documents;

class Document
{
    public function __construct(
        private readonly string $title,
        private readonly string $link,
        private readonly string $content
    ) {
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
