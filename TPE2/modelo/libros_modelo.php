<?php

class LibrosModelo {
    private $db;

    public function __construct() {
        // Conectamos con la base de datos
        $this->db = new PDO('mysql:host=localhost;dbname=db_biblioteca;charset=utf8', 'root', '');
    }
 
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
}

?>


/*  Usa JOIN para traer el nombre y apellido del autor junto con los datos del libro.
    Permite mostrar el listado completo de libros y también el detalle de uno solo.
    Usa id_libro y id_autor como están definidos en tus tablas reales 
*/

