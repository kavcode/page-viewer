<?php declare(strict_types=1);

namespace App\Domain\Documents;

interface DocumentRepositoryInterface
{
    public function findByLink(string $link): ?Document;

    public function findAll(): array;

    public function findByName(string $pattern): array;
}