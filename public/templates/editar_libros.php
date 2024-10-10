<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Editar Libro</title>

</head>

<body>
    <div class="container mt-5">
        <h1>Editar Libro</h1>
        <form action="/libros/edit/<?= $libro->getIsbn(); ?>" method="POST" class="shadow p-4 bg-white rounded">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $libro->getTitulo(); ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="autor">Autor:</label>
                <input type="text" class="form-control" id="autor" name="autor" value="<?= $libro->getAutor(); ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="anio_publicacion">Año de Publicación:</label>
                <input type="number" class="form-control" id="anio_publicacion" name="anio_publicacion"
                    value="<?= $libro->getAnioPublicacion(); ?>" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" class="form-control" name="descripcion"
                    required><?= $libro->getDescripcion(); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>

        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>