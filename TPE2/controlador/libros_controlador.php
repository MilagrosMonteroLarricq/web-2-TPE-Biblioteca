<?php
// Incluimos el modelo y la vista
include_once 'libros_modelo.php';
include_once 'libros_vista.php';

class Controlador {
    private $modelo;
    private $vista;

    function __construct() {
        // Asumiendo que las clases Modelo y Vista existen en sus respectivos archivos
        $this->modelo = new Modelo();
        $this->vista = new Vista();
    }

    // (A) Listado de ítems: Muestra TODOS los libros.
    // Esto corresponde al método "mostrarAutores" que tenías, pero centrado en los Libros.
    function listarLibrosPublico() {
        // Pide todos los libros al Modelo.
        // El Modelo debe devolver un array con todos los datos, incluyendo el nombre del autor.
        $libros = $this->modelo->obtenerTodosLosLibros(); 
        
        if (empty($libros)) {
            $this->vista->mostrarError("No se encontraron libros en la biblioteca.");
        } else {
            // Muestra el listado completo
            $this->vista->mostrarListadoLibros($libros);
        }
    }

    // (A) Detalle de ítem: Muestra un libro particular.
    // Esto corresponde al método "mostrarLibros" que tenías, corregido para buscar por id_libro.
    function mostrarDetalleLibro() {
        // 1. Verifica el parámetro obligatorio (id_libro)
        if (!isset($_GET['id_libro']) || empty($_GET['id_libro'])) {
            $this->vista->mostrarError("Debe indicar el ID del libro.");
            return; // Termina la ejecución
        }
        
        $id_libro = $_GET['id_libro'];
        
        // 2. Pide el detalle del libro al Modelo (incluyendo el nombre del autor)
        $libro = $this->modelo->obtenerDetalleLibro($id_libro);

        // 3. Muestra el resultado
        if (empty($libro)) {
            $this->vista->mostrarError("No se encontró el libro con ID: " . $id_libro);
        } else {
            $this->vista->mostrarDetalleItem($libro); // Nuevo método en la Vista
        }
    }
}
?>

    
