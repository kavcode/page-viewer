<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\ControllerInterface;
use App\Contracts\RequestInterface;
use App\Domain\Documents\DocumentRepositoryFactory;
use App\Services\TemplateRenderer;

class PageController implements ControllerInterface
{
    public function __construct(
        private readonly TemplateRenderer $renderer,
        private readonly DocumentRepositoryFactory $repositoryFactory
    ) {
    }

    public function __invoke(RequestInterface $request): string
    {
        $content = '<p>There is no page with given id</p>';
        $link = $request->getQueryParam('id');

        if ($link) {
            $repository = $this->repositoryFactory->create();
            $document = $repository->findByLink($link);
            if ($document) {
                $content = $this->renderer->render(
                    'documents/view_item.phtml',
                    [
                        'document' => $repository->findByLink($link)
                    ]
                );
            }
        }


        return $this->renderer->render(
            'layouts/default.phtml',
            [
                'content' => $content
            ]
        );
    }
}
