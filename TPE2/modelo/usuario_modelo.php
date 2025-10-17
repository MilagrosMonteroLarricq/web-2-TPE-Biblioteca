<?php
include_once 'TPE2/modelo/modelo.php';

class UsuariosModelo extends Model {
    public function obtenerUsuarioPorEmail($email){
        $query= $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $query->execute([$email]);
        return $query->fetch(PDO::FETCH_OBJ); 
    }
}