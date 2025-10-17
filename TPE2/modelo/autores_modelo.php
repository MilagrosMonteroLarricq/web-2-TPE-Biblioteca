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
        $query = $this->db->prepare("SELECT * FROM autores WHERE id_autor = ?");
        $query->execute([$id_autor]);
        // Devolvemos solo un objeto/fila
        return $query->fetch(PDO::FETCH_OBJ); 
    }


    public function buscarAutorPorNombre($nombre_buscado) {
        $param = '%' . $nombre_buscado . '%';
        $query = $this->db->prepare("
            SELECT id_autor, nombre, apellido, nacionalidad
            FROM autores
            WHERE nombre LIKE ? OR apellido LIKE ? OR CONCAT (nombre, ' ', apellido) LIKE ?
            LIMIT 1
        ");
        $query->execute([$param, $param, $param]);
        return $query->fetch(PDO::FETCH_OBJ); // Retorna el objeto autor para usar su ID
    }

    // Alta - INSERT
    function agregarAutor($nombre, $apellido, $nacionalidad){
        $query = $this->db->prepare("INSERT INTO autores (nombre, apellido, nacionalidad) VALUES (?, ?, ?)");
        $query->execute([$nombre, $apellido, $nacionalidad]);
    }

    // Modificacion - UPDATE
    function editarAutor($id_autor, $nombre, $apellido, $nacionalidad){
        $query = $this->db->prepare("UPDATE autores SET nombre = ?, apellido = ?, nacionalidad = ? WHERE id_autor = ?");
        return $query->execute([$nombre, $apellido, $nacionalidad, $id_autor]);
    }

    // Baja - DELETE
    function eliminarAutor($id_autor){
        $query = $this->db->prepare("DELETE FROM autores WHERE id_autor = ?");
        return $query->execute([$id_autor]);
    }
}
?>