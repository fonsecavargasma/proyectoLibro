<?php

namespace App\Application\Libro\Service;

use App\Domain\Libro\Repository\LibroRepository;

class BuscarLibrosService
{
    private LibroRepository $libroRepository;

    public function __construct(LibroRepository $libroRepository)
    {
        $this->libroRepository = $libroRepository;
    }

    public function execute(string $query): array
    {
        return $this->libroRepository->searchByTitleOrAuthor($query);
    }
}
