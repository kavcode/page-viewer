<?php

declare(strict_types=1);

namespace App\Contracts;

interface ControllerInterface
{
    /**
     * @param RequestInterface $request
     * @return string|ResponseInterface
     */
    public function __invoke(RequestInterface $request): mixed;
}
