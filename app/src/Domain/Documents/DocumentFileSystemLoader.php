<?php

declare(strict_types=1);

namespace App\Domain\Documents;

use App\Markdown\Parser;

class DocumentFileSystemLoader implements DocumentRepositoryInterface
{
    private $sourceDir;
    private $parser;
    private $headlineExtractor;
    private $documents;
    public function __construct(string $sourceDir, Parser $parser, HeadlineExtractor $headlineExtractor)
    {
        $this->sourceDir = $sourceDir;
        $this->parser = $parser;
        $this->headlineExtractor = $headlineExtractor;
    }

    public function findByLink(string $link): ?Document
    {
        $this->loadDocuments();
        foreach ($this->documents as $document) {
        /** @var Document $document */
            if ($document->getLink() === $link) {
                return $document;
            }
        }
        return null;
    }

    public function findAll(): array
    {
        $this->loadDocuments();
        return $this->documents;
    }

    public function findByName(string $pattern): array
    {
        $this->loadDocuments();
        return array_filter($this->documents, function (Document $document) use ($pattern) {

            return strpos($document->getTitle(), $pattern) !== false;
        });
    }

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
