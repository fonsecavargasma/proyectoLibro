<?php

namespace App\Application\Libro\Service;

use App\Domain\Libro\Entity\Libro;
use App\Domain\Libro\Repository\LibroRepository;
use App\Domain\Libro\ValueObject\ISBN;

class ActualizarLibroService
{
    private LibroRepository $libroRepository;

    public function __construct(LibroRepository $libroRepository)
    {
        $this->libroRepository = $libroRepository;
    }

    public function execute(string $isbn, string $titulo, string $autor, int $anioPublicacion, string $descripcion): void
    {
        $isbnValueObject = new ISBN($isbn);
        $libro = new Libro($titulo, $autor, $isbnValueObject, $anioPublicacion, $descripcion);
        $this->libroRepository->update($libro);
    }
}
