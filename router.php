<?php
include_once 'TPE2/controlador/autores_controlador.php';
include_once 'TPE2/controlador/libros_controlador.php';
include_once 'TPE2/controlador/seguridad_controlador.php';
include_once 'TPE2/controlador/home_controlador.php';
include_once 'TPE2/controlador/controlador_admin.php';
include_once 'TPE2/middlewares/auth.helper.php';

// leemos la accion que viene por parametro
$action = 'home'; 

if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

// parsea la accion Ej: dev/juan --> ['dev', juan]
$params = explode('/', $action);

// determina que camino seguir según la acción
switch ($params[0]) {
    case 'home':
        $controller = new ControladorHome();
        $controller->showHome();
        break;

    case 'listarLibros':
        $controller = new ControladorLibros();
        $controller->showLibros();
        break;
    case 'detalleLibros':
        $controller = new ControladorLibros();
        $controller->showDetalleLibro($params[1]);
        break;

    case 'buscarLibro':
        $controller= new ControladorLibros();
        $controller->buscarLibro();
        break;
    case 'buscarAutor':
        $controller= new ControladorAutor();
        $controller->buscarAutor();
        break;
    case 'librosPorAutor':
        $controller = new ControladorAutor();
        // cambiamos a showAutores para que use el método que lista libros por autor
        $controller->showDetalleAutor($params[1]);
        break;

    case 'login': 
        // Muestra el formulario de login (GET)
        $controller = new ControladorSeguridad();
        $controller->mostrarLoginForm(); 
        break;

    case 'verify': 
        // Procesa la petición POST del formulario de login
        $controller = new ControladorSeguridad();
        $controller->verify();
        break;
        
    case 'logout':
        $controller = new ControladorSeguridad(); 
        $controller->logout();
        break;

    
    
    case 'admin':
        AuthHelper::checkAdmin(); // *SEGURIDAD: Solo ADMIN*
        $controller = new ControladorAdministrador(); 
        $controller->showPanelAdmin();
        break;
        
    case 'agregarAutorForm': // Muestra el formulario de Alta (GET)
        AuthHelper::checkAdmin(); // *SEGURIDAD: Solo ADMIN*
        $controller = new ControladorAutor();
        $controller->showFormAgregarAutor();
        break;
        
    case 'agregarAutor': // Procesa la creación (POST)
        AuthHelper::checkAdmin(); // *SEGURIDAD: Solo ADMIN*
        $controller = new ControladorAutor();
        $controller->agregarAutor();
        break;
        
    case 'editarAutorForm': // Muestra el formulario de Edición (GET /id)
        AuthHelper::checkAdmin(); // *SEGURIDAD: Solo ADMIN*
        $controller = new ControladorAutor();
        $controller->showFormEditarAutor($params[1]);
        break;
        
    case 'editarAutor': // Procesa la edición (POST)
        AuthHelper::checkAdmin(); // *SEGURIDAD: Solo ADMIN*
        $controller = new ControladorAutor();
        $controller->editarAutor();
        break;
        
    case 'eliminarAutor': // Procesa la eliminación (GET /id)
        AuthHelper::checkAdmin(); // *SEGURIDAD: Solo ADMIN*
        $controller = new ControladorAutor();
        $controller->eliminarAutor($params[1]);
        break;

    case 'agregarLibroForm':
        AuthHelper::checkAdmin(); // *SEGURIDAD: Solo ADMIN*
        $controller= new ControladorLibros();
        $controller->showFormAgregarLibro();
        break;

    case 'agregarLibro':
        AuthHelper::checkAdmin(); // *SEGURIDAD: Solo ADMIN*
        $controller = new ControladorLibros();
        $controller->agregarLibro();
        break;
    
    case 'editarLibroForm':
        AuthHelper::checkAdmin(); // *SEGURIDAD: Solo ADMIN*
        $controller = new ControladorLibros();
        $controller->showFormEditarLibro($params[1]);
        break;

    case 'editarLibro':
        AuthHelper::checkAdmin(); // *SEGURIDAD: Solo ADMIN*
        $controller= new ControladorLibros;
        $controller->editarLibro();
        break;
    
    case 'eliminarLibro':
        AuthHelper::checkAdmin(); // *SEGURIDAD: Solo ADMIN*
        $controller=new ControladorLibros();
        $controller->eliminarLibro($params[1]);
        break;

    default:
        echo('404 Page not found');
        break;
}
?>