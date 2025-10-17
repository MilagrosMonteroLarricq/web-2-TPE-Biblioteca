<?php
// seguridad_controlador.php
include_once '../modelo/usuarios_modelo.php';
include_once '../vista/libros_vista.phtml';
include_once '../middlewares/auth.helper.php';
/*include_once*/


class ControladorSeguridad {

    private $modelo;
    private $vista;
    private $helper;

    public function __construct(){
        $this->modelo= new UsuariosModelo;
        $this->vista= new LibrosVista;
        $this->helper= new AuthHelper;
    }

    // (A) - Lógica de inicio de sesión
    public function login() {
        
        //Creo la cuenta cuando venga en el POST
        if(!empty($_POST['email'])&& !empty($_POST['password'])){
        $userEmail=$_POST['email'];
        $userPassword=$_POST['password'];

        //Obtengo el usuario de la base de datos
        $db = new PDO('mysql:host=localhost;'.'dbname=db_biblioteca;charset=utf8', 'root', '');
        $query = $db->prepare('SELECT * FROM users WHERE email = ?');
        $query->execute([$userEmail]);
        $user = $query->fetch(PDO::FETCH_OBJ);

        //Si el usuario existe y las contraseñas coinciden
        if($user && $userPassword==($user->password)){
            echo "Acceso exitoso";
        }else{
            echo "Acceso denegado";
        }   
    }

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

    function verify(){
        $userEmail= $_POST['email'] ?? null;
        $userPassword=$_POST['password'] ?? null;
    
        if (empty($userEmail) || empty($userPassword)){
            $this->mostrarLoginForm('DEbe completar ambos campos.');
            return;
        }
        $user = $this->modelo->obtenerUsuarioPorEmail($userEmail);

        if ($user && password_verify($userPassword, $user->password)) {
            // Éxito: iniciar sesión y redirigir
            $this->helper->login($user); 
            header("Location: administrarLibros"); // Redirige al área de ABM
            die();
        } else {
            // Fallo: Volver a mostrar el formulario con error
            $this->mostrarLoginForm('Usuario o contraseña incorrectos.');
        }
    }

    public function mostrarLoginForm($error = null) {
        $this->vista->mostrarLogin($error); 
    }
}
?>