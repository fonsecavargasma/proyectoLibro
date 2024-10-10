<?php

namespace App\Domain\Libro\Entity;

use App\Domain\Libro\ValueObject\ISBN;

class Libro
{
    private string $titulo;
    private string $autor;
    private ISBN $isbn;
    private int $anioPublicacion;
    private string $descripcion;

    public function __construct(string $titulo, string $autor, ISBN $isbn, int $anioPublicacion, string $descripcion)
    {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->isbn = $isbn;
        $this->anioPublicacion = $anioPublicacion;
        $this->descripcion = $descripcion;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getAutor(): string
    {
        return $this->autor;
    }

    public function getIsbn(): ISBN
    {
        return $this->isbn;
    }

    public function getAnioPublicacion(): int
    {
        return $this->anioPublicacion;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }
}
