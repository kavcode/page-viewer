<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\RequestInterface;

class Request implements RequestInterface
{
    public function __construct(
        private readonly string $path,
        private readonly array $query
    ) {
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQueryParam(string $key): ?string
    {
        return isset($this->query[$key])
            ? trim(strip_tags((string) $this->query[$key]))
            : null;
    }
}
