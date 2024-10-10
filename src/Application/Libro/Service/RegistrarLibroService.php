<?php

namespace App\Application\Libro\Service;

use App\Domain\Libro\Entity\Libro;
use App\Domain\Libro\ValueObject\ISBN;
use App\Domain\Libro\Repository\LibroRepository;

class RegistrarLibroService
{
    private LibroRepository $libroRepository;

    public function __construct(LibroRepository $libroRepository)
    {
        $this->libroRepository = $libroRepository;
    }

    public function execute(string $titulo, string $autor, string $isbn, int $anioPublicacion, string $descripcion): void
    {
        $isbnValueObject = new ISBN($isbn);
        $libro = new Libro($titulo, $autor, $isbnValueObject, $anioPublicacion, $descripcion);
        $this->libroRepository->save($libro);
    }
}
