<?php
include_once 'TPE2/controlador/autores_controlador.php';
include_once 'TPE2/controlador/libros_controlador.php';

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
    case 'detalleAutor':
        $controller= new ControladorAutor();
        $controller->showDetalleAutor($params[1]); 
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
        $controller->showAutores($params[1]);
        break;
    case 'login': 
        $controller = new ControladorSeguridad();
        $controller->login();
        break;
    case 'logout': // (B) - FUNCIONAL
        $controller = new ControladorSeguridad(); 
        $controller->logout();
        break;

    default:
        echo('404 Page not found');
        break;
}
?>
