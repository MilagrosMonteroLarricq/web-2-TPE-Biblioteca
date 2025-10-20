<?php
include_once 'TPE2/controlador/autores_controlador.php';
include_once 'TPE2/controlador/libros_controlador.php';
include_once 'TPE2/controlador/seguridad_controlador.php';

// leemos la accion que viene por parametro
$action = 'listarLibros'; // acción por defecto

if (!empty($_GET['action'])) { // si viene definida la reemplazamos
    $action = $_GET['action'];
}

// parsea la accion Ej: dev/juan --> ['dev', juan]
$params = explode('/', $action);

// determina que camino seguir según la acción
switch ($params[0]) {
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

    case 'listarAutores':
        $controller = new ControladorAutor();
        $controller->showAutores(); // Llama al método que lista todas las categorías
        break;
        
    case 'agregarAutorForm': // Muestra el formulario de Alta (GET)
        $controller = new ControladorAutor();
        $controller->showFormAgregarAutor();
        break;
        
    case 'agregarAutor': // Procesa la creación (POST)
        $controller = new ControladorAutor();
        $controller->agregarAutor();
        break;
        
    case 'editarAutorForm': // Muestra el formulario de Edición (GET /id)
        $controller = new ControladorAutor();
        $controller->showFormEditarAutor($params[1]);
        break;
        
    case 'editarAutor': // Procesa la edición (POST)
        $controller = new ControladorAutor();
        $controller->editarAutor();
        break;
        
    case 'eliminarAutor': // Procesa la eliminación (GET /id)
        $controller = new ControladorAutor();
        $controller->eliminarAutor($params[1]);
        break;

    default:
        echo('404 Page not found');
        break;
}
?>
