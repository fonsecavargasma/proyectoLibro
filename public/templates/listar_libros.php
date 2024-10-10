<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Buscar Libros</title>

</head>

<body>
    <div class="container mt-5">
        <h1>Buscar Libros</h1>

        <!-- Formulario de búsqueda -->
        <form action="/libros/search" method="GET">
            <input type="text" name="q" placeholder="Buscar por título o autor" required>
            <button type="submit">Buscar</button>
        </form>

        <h2>Resultados de la búsqueda</h2>
        <table class="table table-bordered">
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>ISBN</th>
                <th>Año de Publicación</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
            <?php if (isset($libros) && count($libros) > 0): ?>
            <?php foreach ($libros as $libro): ?>
            <tr>
                <td><?= htmlspecialchars($libro->getTitulo()); ?></td>
                <td><?= htmlspecialchars($libro->getAutor()); ?></td>
                <td><?= htmlspecialchars($libro->getIsbn()->getIsbn());?></td>
                <td><?= htmlspecialchars($libro->getAnioPublicacion()); ?></td>
                <td><?= $libro->getDescripcion(); ?></td>
                <td><a href="/libros/edit?isbn=<?php echo urlencode(htmlspecialchars($libro->getIsbn()->getIsbn())); ?>"
                        class="btn btn-primary btn-sm">Editar</a>
                    <form action="/libros/delete" method="POST" style="display:inline;">
                        <input type="hidden" name="isbn"
                            value="<?php echo htmlspecialchars($libro->getIsbn()->getIsbn(), ENT_QUOTES, 'UTF-8'); ?>">
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Estás seguro de eliminar este libro?');">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="5">No se encontraron libros.</td>
            </tr>
            <?php endif; ?>
        </table>
        <br>
        <a class="btn btn-success" href="/libros/create">Agregar Nuevo Libro</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>