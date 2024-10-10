<?php

namespace App\Application\Libro\Service;

use App\Domain\Libro\Repository\LibroRepository;

class ListarLibrosService
{
    private LibroRepository $libroRepository;

    public function __construct(LibroRepository $libroRepository)
    {
        $this->libroRepository = $libroRepository;
    }

    public function execute(): array
    {
        return $this->libroRepository->findAll();
    }
}
