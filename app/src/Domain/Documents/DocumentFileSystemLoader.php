<?php

declare(strict_types=1);

namespace App\Domain\Documents;

use App\Markdown\Parser;

class DocumentFileSystemLoader implements DocumentRepositoryInterface
{
    /**
     * @var Document[]|null
     */
    private ?array $documents = null;

    public function __construct(
        private readonly string $sourceDir,
        private readonly Parser $parser,
        private readonly HeadlineExtractor $headlineExtractor
    ) {
    }

    public function findByLink(string $link): ?Document
    {
        $documents = $this->loadDocuments();
        foreach ($documents as $document) {
            if ($document->getLink() === $link) {
                return $document;
            }
        }
        return null;
    }

    public function findAll(): array
    {
        return $this->loadDocuments();
    }

    public function findByName(string $pattern): array
    {
        return array_filter(
            $this->loadDocuments(),
            fn(Document $document) => str_contains($document->getTitle(), $pattern)
        );
    }

    /**
     * @return Document[]
     */
    private function loadDocuments(): array
    {
        if ($this->documents !== null) {
            return $this->documents;
        }

        $dir = opendir($this->sourceDir);
        $this->documents = [];
        while ($name = readdir($dir)) {
            if ($name === '.' || $name === '..') {
                continue;
            }

            $path = $this->sourceDir . DIRECTORY_SEPARATOR . $name;
            if (!preg_match('/^(.*)\.(html|txt)$/', $name, $match)) {
                continue;
            }

            if (!is_readable($path)) {
                continue;
            }

            $link = trim($match[1]);
            if (!$link) {
                continue;
            }

            if ($match[2] === 'txt') {
                $result = $this->parser->parseFromLineArray(file($path));
                $this->documents[] = new Document($result->getTitle(), $link, $result->getHtml());
            }

            if ($match[2] === 'html') {
                $content = file_get_contents($path);
                $title = $this->headlineExtractor->extract($content);
                if (!$title) {
                    $title = '[untitled]';
                }

                $this->documents[] = new Document($title, $link, $content);
            }
        }

        closedir($dir);
        return $this->documents;
    }
}
