<?php declare(strict_types=1);

namespace App\Services;

class FrontController
{
    private $router;
    private $responseFactory;

    public function __construct(
        Router $router,
        ResponseFactory $responseFactory
    )
    {
        $this->router = $router;
        $this->responseFactory = $responseFactory;
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

        throw new \RuntimeException(
            "Controller returns bad result"
        );
    }
}