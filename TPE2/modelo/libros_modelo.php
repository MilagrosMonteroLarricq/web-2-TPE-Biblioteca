<?php
include_once 'TPE2/modelo/modelo.php';

class LibrosModelo extends Model{
    // Obtener todos los libros con su categoría
    public function obtenerLibros() {
        $query = $this->db->prepare('
            SELECT libros.*, autores.nombre AS nombre_autor, autores.apellido AS apellido_autor
            FROM libros
            JOIN autores ON libros.id_autor = autores.id_autor
        ');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    // Obtener un solo libro por su id (para el detalle)
    public function obtenerLibroPorId($id) {
        $query = $this->db->prepare('
            SELECT libros.*, autores.nombre AS nombre_autor, autores.apellido AS apellido_autor
            FROM libros
            JOIN autores ON libros.id_autor = autores.id_autor
            WHERE libros.id_libro = ?
        ');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function obtenerLibrosPorAutor($id_autor) {
        // La consulta es similar a obtenerLibros(), pero con un filtro WHERE
        $query = $this->db->prepare('
            SELECT libros.*, autores.nombre AS nombre_autor, autores.apellido AS apellido_autor
            FROM libros
            JOIN autores ON libros.id_autor = autores.id_autor
            WHERE libros.id_autor = ?
        ');
        $query->execute([$id_autor]);
        return $query->fetchAll(PDO::FETCH_OBJ); // Devuelve un array de libros
    }


    public function buscarLibroPorTitulo($titulo_buscado) {
        $query = $this->db->prepare("
            SELECT l.*, a.nombre AS nombre_autor, a.apellido AS apellido_autor
            FROM libros l
            JOIN autores a ON l.id_autor = a.id_autor
            WHERE l.titulo LIKE ?
            LIMIT 1
        ");
        // Usamos LIKE con comodín inicial y final para encontrar coincidencias parciales si lo deseas, 
        // o sin comodines si quieres la coincidencia exacta. Aquí usamos comodines.
        $query->execute(['%' . $titulo_buscado . '%']); 
        return $query->fetch(PDO::FETCH_OBJ); 
    }

    function agregarLibro($titulo, $genero, $anio_publicacion, $editorial, $id_autor){
        $query = $this->db->prepare("
            INSERT INTO libros (titulo, genero, anio_publicacion, editorial, id_autor) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $query->execute([$titulo, $genero, $anio_publicacion, $editorial, $id_autor]);
    }


    // Modificacion - UPDATE
    function editarLibro($id_libro, $titulo, $genero, $anio_publicacion, $editorial, $id_autor){
        $query = $this->db->prepare("UPDATE libros SET titulo = ?, genero = ?, anio_publicacion = ?, $editorial = ?, $id_autor WHERE id_libro = ?");
        return $query->execute([$titulo, $genero, $anio_publicacion, $editorial, $id_autor, $id_libro]);
    }

    // Baja - DELETE
    function eliminarLibro($id_libro){
        $query = $this->db->prepare("DELETE FROM libros WHERE id_libro = ?");
        return $query->execute([$id_libro]);
    }
}
?>










