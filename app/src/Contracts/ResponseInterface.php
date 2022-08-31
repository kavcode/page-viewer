<?php

namespace App\Contracts;

interface ResponseInterface
{
    public function getCode(): int;
    public function getContent(): string;
}
