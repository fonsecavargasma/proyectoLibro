<?php

namespace App\Domain\Libro\ValueObject;

class ISBN
{
    private string $isbn;

    public function __construct(string $isbn)
    {
        if (!$this->esValidoISBN($isbn)) {
            throw new \InvalidArgumentException("ISBN inválido");
        }
        $this->isbn = $isbn;
    }

    private function esValidoISBN(string $isbn): bool
    {

        return preg_match('/^\d{10}(\d{3})?$/', $isbn) === 1;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function __toString(): string
    {
        return $this->isbn;
    }
}
