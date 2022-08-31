<?php

declare(strict_types=1);

namespace App\Services;

class RequestFactory
{
    public function createFromGlobals(): Request
    {
        return new Request((string) $_SERVER['DOCUMENT_URI'], $_GET);
    }
}
