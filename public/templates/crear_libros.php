<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Agregar Libro</title>

</head>

<body>
    <div class="container mt-5">
        <h1>Agregar Libro</h1>
        <form action="/libros/create" method="POST" class="shadow p-4 bg-white rounded">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>

            <div class="form-group">
                <label for="autor">Autor:</label>
                <input type="text" class="form-control" id="autor" name="autor" required>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" class="form-control" id="isbn" name="isbn" required>
            </div>

            <div class="form-group">
                <label for="anio_publicacion">Año de Publicación:</label>
                <input type="number" class="form-control" id="anio_publicacion" name="anio_publicacion" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" class="form-control" name="descripcion" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Agregar Libro</button>
            <a href="/libros" class="btn btn-secondary">Volver a la lista</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>