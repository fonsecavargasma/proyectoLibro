<?php

namespace App\Domain\Libro\Repository;

use App\Domain\Libro\Entity\Libro;

interface LibroRepository
{
    public function save(Libro $libro): void;
    public function findByISBN(string $isbn): ?Libro;
    public function findAll(): array;
    public function deleteByISBN(string $isbn): void;
    public function update(Libro $libro): void;
    public function searchByTitleOrAuthor(string $query): array;
}
