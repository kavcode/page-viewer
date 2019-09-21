<?php declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Documents\DocumentRepositoryFactory;
use App\Services\Request;
use App\Services\TemplateRenderer;

class SearchController
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
        $documents = [];
        $term = $request->getQueryParam('term');

        if ($term) {
            $repository = $this->repositoryFactory->create();
            $documents = $repository->findByName($term);
        }

        $content = $this->renderer->render(
            'documents/view_collection.phtml', [
                'documents' => $documents,
                'term' => $term
            ]
        );

        return $this->renderer->render(
            'layouts/default.phtml', [
                'content' => $content,
                'term' => $term
            ]
        );
    }
}