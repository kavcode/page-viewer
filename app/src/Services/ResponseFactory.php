<?php declare(strict_types=1);

namespace App\Services;

class ResponseFactory
{
    public function createFromString(string $content, int $code): Response
    {
        return new Response($content, $code);
    }
}