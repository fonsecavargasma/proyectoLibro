<?php
require '../vendor/autoload.php';

use App\Infrastructure\Libro\Repository\MySQLLibroRepository;
use App\Application\Libro\Service\RegistrarLibroService;
use App\Application\Libro\Service\BuscarLibroEnOpenLibraryService;
use App\Application\Libro\Service\BuscarLibrosService;
use App\Application\Libro\Service\EliminarLibroService;
use App\Application\Libro\Service\ActualizarLibroService;

// Conexión a la base de datos
$dsn = 'mysql:host=db;dbname=DBLibros;port:8889;charset=utf8mb4';
$username = 'root';
$password = 'root';

try {

    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    echo "Error de conexión: " . $e->getMessage();

    error_log("Error de conexión a la base de datos: " . $e->getMessage(), 3, "/var/log/mysql_errors.log");
    exit;
}


if ($pdo) {
    $libroRepository = new MySQLLibroRepository($pdo);
} else {

    echo "Error: No se pudo crear el repositorio de libros.";
    exit;
}

// Vistas y Rutas
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];


switch ($requestUri) {
        // Lista de libros
    case '/libros':
        if ($requestMethod === 'GET') {
            $libros = $libroRepository->findAll();
            include 'templates/listar_libros.php';
        }
        break;

        // Crear un nuevo libro
    case '/libros/create':
        if ($requestMethod === 'GET') {
            include 'templates/crear_libros.php';
        } elseif ($requestMethod === 'POST') {
            // Registrar libro
            $registrarLibroService = new RegistrarLibroService($libroRepository);
            $buscarLibroEnOpenLibraryService = new BuscarLibroEnOpenLibraryService();

            // Obtener datos del formulario
            $titulo = htmlspecialchars(trim($_POST['titulo']));
            $autor = htmlspecialchars(trim($_POST['autor']));
            $isbn = htmlspecialchars(trim($_POST['isbn']));
            $anioPublicacion = (int)$_POST['anio_publicacion'];
            $descripcion = htmlspecialchars(trim($_POST['descripcion']));

            // Buscar libro en OpenLibrary
            $libroData = null;
            if (!empty($isbn)) {
                $libroData = $buscarLibroEnOpenLibraryService->buscarPorISBN($isbn);
            }

            if (!$libroData && (!empty($titulo) || !empty($autor))) {
                $libroData = $buscarLibroEnOpenLibraryService->buscarPorTituloOAutor($titulo ?: $autor);
            }

            if ($libroData) {
                $titulo = $libroData['title'] ?? $titulo;
                $autor = $libroData['authors'][0]['name'] ?? $autor;
                $descripcion = $libroData['description'] ?? $descripcion;
            }


            $registrarLibroService->execute($titulo, $autor, $isbn, $anioPublicacion, $descripcion);


            header("Location: /libros");
            exit;
        }
        break;

        // Buscar libros por título o autor
    case '/libros/search':
        if ($requestMethod === 'GET') {
            $buscarLibrosService = new BuscarLibrosService($libroRepository);
            $query = $_GET['q'] ?? '';
            $libros = $buscarLibrosService->execute($query);


            include 'templates/listar_libros.php';
        }
        break;

        // Eliminar libro
    case '/libros/delete':
        if ($requestMethod === 'POST') {
            $isbn = $_POST['isbn'];
            $eliminarLibroService = new EliminarLibroService($libroRepository);
            $eliminarLibroService->execute($isbn);


            header("Location: /libros");
            exit;
        }
        break;

        // Edición de libro
    case '/libros/edit':
        if ($requestMethod === 'GET') {
            $isbn = $_GET['isbn'];
            $libro = $libroRepository->findByISBN($isbn);
            include 'templates/editar_libros.php';
        } elseif ($requestMethod === 'POST') {

            $isbn = $_POST['isbn'];
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $anioPublicacion = (int)$_POST['anio_publicacion'];
            $descripcion = $_POST['descripcion'];

            $actualizarLibroService = new ActualizarLibroService($libroRepository);
            $actualizarLibroService->execute($isbn, $titulo, $autor, $anioPublicacion, $descripcion);


            header("Location: /libros");
            exit;
        }
        break;

    default:
        // No encontrada (404)
        echo "Página no encontrada";
        break;
}
