<?php

declare(strict_types=1);

namespace App\Domain\Documents;

interface DocumentRepositoryInterface
{
    public function findByLink(string $link): ?Document;

    /**
     * @return Document[]
     */
    public function findAll(): array;

    /**
     * @param string $pattern
     * @return Document[]
     */
    public function findByName(string $pattern): array;
}
