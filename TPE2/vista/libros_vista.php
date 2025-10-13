<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    class LibrosVista {

        // 🔹 Muestra el listado de todos los libros
        public function mostrarLibros($libros) {
            ?>
            <h1>Listado de Libros</h1>
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Género</th>
                        <th>Año de Publicación</th>
                        <th>Editorial</th>
                        <th>Autor</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($libros as $libro): ?>
                        <tr>
                            <td><?= htmlspecialchars($libro->titulo) ?></td>
                            <td><?= htmlspecialchars($libro->genero) ?></td>
                            <td><?= htmlspecialchars($libro->anio_publicacion) ?></td>
                            <td><?= htmlspecialchars($libro->editorial) ?></td>
                            <td><?= htmlspecialchars($libro->nombre_autor . ' ' . $libro->apellido_autor) ?></td>
                            <td>
                                <a href="verLibro/<?= $libro->id_libro ?>">Ver detalle</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php
        }

        // 🔹 Muestra el detalle de un solo libro
        public function mostrarDetalleLibro($libro) {
            ?>
            <h1>Detalle del Libro</h1>

            <?php if ($libro): ?>
                <p><strong>Título:</strong> <?= htmlspecialchars($libro->titulo) ?></p>
                <p><strong>Género:</strong> <?= htmlspecialchars($libro->genero) ?></p>
                <p><strong>Año de publicación:</strong> <?= htmlspecialchars($libro->anio_publicacion) ?></p>
                <p><strong>Editorial:</strong> <?= htmlspecialchars($libro->editorial) ?></p>
                <p><strong>Autor:</strong> <?= htmlspecialchars($libro->nombre_autor . ' ' . $libro->apellido_autor) ?></p>

                <a href="listarLibros">Volver al listado</a>
            <?php else: ?>
                <p>No se encontró el libro solicitado.</p>
            <?php endif; ?>
            <?php
        }
    }
    ?>
</body>
</html>