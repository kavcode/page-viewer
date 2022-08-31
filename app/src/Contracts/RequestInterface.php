<?php

namespace App\Contracts;

interface RequestInterface
{
    public function getPath(): string;
    public function getQueryParam(string $key): ?string;
}
