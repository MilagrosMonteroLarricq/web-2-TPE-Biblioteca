<?php
// seguridad_controlador.php

class ControladorSeguridad {

    // (A) - Lógica de inicio de sesión
    public function login() {
    }

    // (A) & (B) - Método para verificar si el usuario está logueado
    public function logueado() {
        session_start();
        // Si no está logueado, redirige al formulario de login
        if (!isset($_SESSION['ADMIN_LOGUEADO']) || $_SESSION['ADMIN_LOGUEADO'] !== true) {
            header("Location: login.php");
            exit();
        }
    }
    
    // (B) - Método de deslogueo (Logout) - TU CÓDIGO FUNCIONAL
    function logout(){
    //1. inicia la sesion
    session_start();

    //2. destruye todas las variables de la sesion
    session_destroy();

    //3. redirige al usuario a la pagina de inicio de sesion
    header("location: login.php");

    //4. finaliza la ejecucion del script
    exit();
    }
}
?>