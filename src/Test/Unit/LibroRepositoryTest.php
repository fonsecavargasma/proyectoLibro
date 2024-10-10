<?php

namespace Tests\Unit;

use App\Domain\Libro\Entity\Libro;
use App\Domain\Libro\ValueObject\ISBN;
use PHPUnit\Framework\TestCase;
use App\Infrastructure\Libro\Repository\MySQLLibroRepository;
use PDO;

class LibroRepositoryTest extends TestCase
{
    private $pdo;
    private $libroRepository;

    protected function setUp(): void
    {
        // Configura una conexión a la base de datos en memoria para pruebas
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec("CREATE TABLE libros (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            titulo TEXT,
            autor TEXT,
            isbn TEXT,
            anio_publicacion INTEGER,
            descripcion TEXT
        )");
        $this->libroRepository = new MySQLLibroRepository($this->pdo);
    }

    public function testCrearLibro()
    {
        // Prueba la creación de un libro
        $isbn = new ISBN('9788430607763');
        $libro = new Libro(
            "El secreto",
            "Rhonda Byrne",
            $isbn,
            2006,
            "Un libro que explora la ley de la atracción."
        );
        $this->libroRepository->save($libro);

        $libros = $this->libroRepository->findAll();
        $this->assertCount(1, $libros);
        $this->assertEquals('El secreto', $libros[0]->getTitulo());
    }

    protected function tearDown(): void
    {
        $this->pdo = null;
    }
}
