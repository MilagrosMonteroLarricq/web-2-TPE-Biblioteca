<?php
require_once 'autores_controlador.php';
require_once 'libros_controlador.php';

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
    case 'librosPorAutor':
        $controller = new ControladorAutor();
        $controller->showAutores($params[1]);
        break;
    case 'mostrarAutor':
        $controller = new ControladorAutor();
        $controller->showLibrosByAutor($params[1]);
    default:
        echo('404 Page not found');
        break;
}
?>
