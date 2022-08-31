<?php

declare(strict_types=1);

namespace App\Services;

class Request
{
    private $path;
    private $query;
    public function __construct(string $path, array $query)
    {
        $this->path = $path;
        $this->query = $query;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQueryParam(string $key): ?string
    {
        return $this->query[$key]
            ? trim(strip_tags($this->query[$key]))
            : null;
    }
}
