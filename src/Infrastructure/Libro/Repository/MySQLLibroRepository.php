<?php

namespace App\Infrastructure\Libro\Repository;

use App\Domain\Libro\Entity\Libro;
use App\Domain\Libro\ValueObject\ISBN;
use App\Domain\Libro\Repository\LibroRepository;

class MySQLLibroRepository implements LibroRepository
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Libro $libro): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO libros (titulo, autor, isbn, anio_publicacion, descripcion) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $libro->getTitulo(),
            $libro->getAutor(),
            $libro->getIsbn()->getIsbn(),
            $libro->getAnioPublicacion(),
            $libro->getDescripcion()
        ]);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM libros");
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $libros = [];
        foreach ($data as $row) {
            $libros[] = new Libro(
                $row['titulo'],
                $row['autor'],
                new ISBN($row['isbn']),
                (int)$row['anio_publicacion'],
                $row['descripcion']
            );
        }

        return $libros;
    }

    public function findByISBN(string $isbn): ?Libro
    {
        $stmt = $this->pdo->prepare("SELECT * FROM libros WHERE isbn = ?");
        $stmt->execute([$isbn]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Libro(
            $data['titulo'],
            $data['autor'],
            new ISBN($data['isbn']),
            (int)$data['anio_publicacion'],
            $data['descripcion']
        );
    }

    public function deleteByISBN(string $isbn): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM libros WHERE isbn = ?");
        $stmt->execute([$isbn]);
    }

    public function update(Libro $libro): void
    {
        $stmt = $this->pdo->prepare("UPDATE libros SET titulo = ?, autor = ?, anio_publicacion = ?, descripcion = ? WHERE isbn = ?");
        $stmt->execute([
            $libro->getTitulo(),
            $libro->getAutor(),
            $libro->getAnioPublicacion(),
            $libro->getDescripcion(),
            $libro->getIsbn()->getIsbn()
        ]);
    }

    public function searchByTitleOrAuthor(string $query): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM libros 
            WHERE titulo LIKE :query OR autor LIKE :query
        ");
        $stmt->execute(['query' => '%' . $query . '%']);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $libros = [];
        foreach ($data as $row) {
            $libros[] = new Libro(
                $row['titulo'],
                $row['autor'],
                new ISBN($row['isbn']),
                (int)$row['anio_publicacion'],
                $row['descripcion']
            );
        }

        return $libros;
    }
}
