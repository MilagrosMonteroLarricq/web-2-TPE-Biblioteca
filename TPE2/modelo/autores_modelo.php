<?php
include_once 'TPE2/modelo/modelo.php';

class AutorModelo extends Model {
    // Obtener todos los autores
    function obtenerTodosLosAutores() {
        $query = $this->db->prepare("SELECT * FROM autores");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    // Obtener libros de un autor específico
    function obtenerLibrosPorAutor($id_autor){
        $query = $this->db->prepare("
        SELECT l.* , a.nombre AS nombre_autor, a.apellido AS apellido_autor
        FROM libros l
        JOIN autores a ON l.id_autor = a.id_autor
        WHERE a.id_autor = ?
        ");
        $query->execute([$id_autor]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}
?>