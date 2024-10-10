<?php

namespace App\Application\Libro\Service;

use App\Domain\Libro\Repository\LibroRepository;

class EliminarLibroService
{
    private LibroRepository $libroRepository;

    public function __construct(LibroRepository $libroRepository)
    {
        $this->libroRepository = $libroRepository;
    }

    public function execute(string $isbn): void
    {
        $this->libroRepository->deleteByISBN($isbn);
    }
}
