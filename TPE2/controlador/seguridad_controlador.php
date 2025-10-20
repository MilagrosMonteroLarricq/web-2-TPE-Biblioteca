<?php

include_once 'TPE2/modelo/usuario_modelo.php'; 
include_once 'TPE2/vista/login.phtml'; 
include_once 'TPE2/middlewares/auth.helper.php';

class ControladorSeguridad {

    private $modelo;
    private $vista;
    private $helper;

    public function __construct(){
        $this->modelo = new UsuariosModelo(); 
        $this->vista = new LoginVista(); 
        $this->helper = new AuthHelper();
    }
    
    // Muestra el formulario de login (GET)
    public function mostrarLoginForm($error = null) {

        $this->vista->mostrarLogin($error); 
    }

    // Procesa el POST del login (POST action="verify")
    function verify(){
        $userEmail= $_POST['email'] ?? null;
        $userPassword=$_POST['password'] ?? null;
    
        if (empty($userEmail) || empty($userPassword)){
            $this->mostrarLoginForm('Debe completar ambos campos.');
            return;
        }
        
        // 1. Obtener usuario del modelo
        $user = $this->modelo->obtenerUsuarioPorEmail($userEmail);

        // 2. Verificar usuario y contraseña (usando password_verify)
        if ($user && password_verify($userPassword, $user->password)) {
            // Éxito: iniciar sesión y redirigir
            $this->helper->login($user); 
            // Redirige al listado de libros (donde se ve la opción ABM)
            header("Location: listarLibros"); 
            die();
        } else {
            // Fallo: Volver a mostrar el formulario con error
            $this->mostrarLoginForm('Usuario o contraseña incorrectos.');
        }
    }
    
    // Cierre de sesión (Logout)
    function logout(){
        $this->helper->logout(); // Uso del AuthHelper
    }
    
    // NOTA: ELIMINAR EL MÉTODO logueado() y usar AuthHelper::checkLoggedIn() directamente en los controladores ABM.
}
?>