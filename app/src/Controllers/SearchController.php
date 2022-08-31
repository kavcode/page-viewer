<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\ControllerInterface;
use App\Contracts\RequestInterface;
use App\Domain\Documents\DocumentRepositoryFactory;
use App\Services\TemplateRenderer;

class SearchController implements ControllerInterface
{
    public function __construct(
        private readonly TemplateRenderer $renderer,
        private readonly DocumentRepositoryFactory $repositoryFactory
    ) {
    }

    public function __invoke(RequestInterface $request): string
    {
        $documents = [];
        $term = $request->getQueryParam('term');
        if ($term) {
            $repository = $this->repositoryFactory->create();
            $documents = $repository->findByName($term);
        }

        $content = $this->renderer->render(
            'documents/view_collection.phtml',
            [
                'documents' => $documents,
                'term' => $term
            ]
        );

        return $this->renderer->render(
            'layouts/default.phtml',
            [
                'content' => $content,
                'term' => $term
            ]
        );
    }
}
