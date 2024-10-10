CREATE DATABASE IF NOT EXISTS DBLibros;
USE DBLibros;

CREATE TABLE IF NOT EXISTS libros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) UNIQUE,
    anio_publicacion INT NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO libros (titulo, autor, isbn, anio_publicacion, descripcion)
VALUES ('Ejemplo de Libro', 'Autor Ejemplo', '1234567890123', 2024, 'Descripción de ejemplo');

