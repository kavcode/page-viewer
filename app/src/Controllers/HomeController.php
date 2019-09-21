<?php declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Documents\DocumentRepositoryFactory;
use App\Services\Request;
use App\Services\ResponseFactory;
use App\Services\TemplateRenderer;

class HomeController
{
    private $renderer;
    private $repositoryFactory;

    public function __construct(
        TemplateRenderer $renderer,
        DocumentRepositoryFactory $repositoryFactory
    )
    {
        $this->renderer = $renderer;
        $this->repositoryFactory = $repositoryFactory;
    }

    public function __invoke(Request $request)
    {
        $repository = $this->repositoryFactory->create();

        $content = $this->renderer->render(
           'documents/view_collection.phtml', [
               'documents' => $repository->findAll()
            ]
        );

        return $this->renderer->render(
            'layouts/default.phtml', [
                'content' => $content
            ]
        );
    }
}