<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\ControllerInterface;
use App\Contracts\RequestInterface;
use App\Domain\Documents\DocumentRepositoryFactory;
use App\Services\TemplateRenderer;

class HomeController implements ControllerInterface
{
    public function __construct(
        private readonly TemplateRenderer $renderer,
        private readonly DocumentRepositoryFactory $repositoryFactory
    ) {
    }

    public function __invoke(RequestInterface $request): string
    {
        $repository = $this->repositoryFactory->create();

        $content = $this->renderer->render(
            'documents/view_collection.phtml',
            [
               'documents' => $repository->findAll()
            ]
        );

        return $this->renderer->render(
            'layouts/default.phtml',
            [
                'content' => $content
            ]
        );
    }
}
