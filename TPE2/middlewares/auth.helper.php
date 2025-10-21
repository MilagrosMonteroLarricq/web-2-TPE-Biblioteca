<?php
// En web-2-TPE-BIBLIOTECA/auth_helper.php

// Define la URL base para las redirecciones (AJUSTA ESTA RUTA SI ES NECESARIO)
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/web-2-TPE-BIBLIOTECA/'); 
}

class AuthHelper {
    
    // Inicia la sesión al crear el helper si no está activa
    public function __construct() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    // Inicia la sesión y guarda datos del usuario
    public function login($user) {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION['ID_USUARIO'] = $user->id_usuario;
        $_SESSION['EMAIL'] = $user->email;
        $_SESSION['ROL'] = $user->rol; 
        $_SESSION['IS_LOGGED'] = true; // Flag principal
    }

    // Cierra la sesión
    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL . "login"); 
        die();
    }

    // Método estático para proteger rutas: verifica si hay sesión activa
    public static function checkLoggedIn() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        // Si no está logueado, redirige al login
        if (!isset($_SESSION['IS_LOGGED']) || $_SESSION['IS_LOGGED'] !== true) {
            header("Location: " . BASE_URL . "login"); 
            die();
        }
    }

    // Nuevo método estático para proteger rutas: verifica si el usuario es 'admin'
    public static function checkAdmin() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }

        // 1. Verifica si está logueado
        if (!isset($_SESSION['IS_LOGGED']) || $_SESSION['IS_LOGGED'] !== true) {
            header("Location: " . BASE_URL . "login"); 
            die();
        }
        
        // 2. Verifica si el rol es 'admin'
        // IMPORTANTE: Asegúrate de que el valor del rol de administrador en tu DB sea 'admin'
        if (!isset($_SESSION['ROL']) || $_SESSION['ROL'] !== 'admin') {
            // Si no es admin, redirige al home (ej. 403 Forbidden)
            header("Location: " . BASE_URL . "home"); 
            die();
        }
    }
}
?>