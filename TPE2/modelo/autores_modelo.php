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
    function obtenerAutorPorId($id_autor){
        $query = $this->db->prepare("
        SELECT nombre, apellido, nacionalidad 
        FROM autores 
        WHERE id_autor = ?
        ");
        $query->execute([$id_autor]);
        // Devolvemos solo un objeto/fila
        return $query->fetch(PDO::FETCH_OBJ); 
    }

    
}
?>