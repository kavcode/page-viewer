<?php

declare(strict_types=1);

namespace App\Services;

class FrontController
{
    public function __construct(
        private readonly Router $router,
        private readonly ResponseFactory $responseFactory
    ) {
    }

    public function handle(Request $request): Response
    {
        $controller = $this->router->resolve($request);
        $result = $controller($request);
        if ($result instanceof Response) {
            return $result;
        }

        if (is_string($result)) {
            return $this->responseFactory->createFromString($result, 200);
        }

        throw new \RuntimeException("Controller returns bad result");
    }
}
