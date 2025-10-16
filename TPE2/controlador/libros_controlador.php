<?php
// Incluimos el modelo y la vista
include_once 'TPE2/modelo/libros_modelo.php';
include_once 'TPE2/modelo/autores_modelo.php';
include_once 'TPE2/vista/libros_vista.phtml';

class ControladorLibros {
    private $modelo;
    private $vista;

    function __construct() {
        // Asumiendo que las clases Modelo y Vista existen en sus respectivos archivos
        $this->modelo = new LibrosModelo();
        $this->vista = new LibrosVista();
    }

    // (A) Listado de ítems: Muestra TODOS los libros.
    // Esto corresponde al método "mostrarAutores" que tenías, pero centrado en los Libros.
    function showLibros() {
        // Pide todos los libros al Modelo.
        // El Modelo debe devolver un array con todos los datos, incluyendo el nombre del autor.
        $libros = $this->modelo->obtenerLibros(); 
        
        if (empty($libros)) {
            $this->vista->mostrarError("No se encontraron libros en la biblioteca.");
        } else {
            // Muestra el listado completo
            $this->vista->mostrarLibros($libros);
        }
    }

    // (A) Detalle de ítem: Muestra un libro particular.
    // Esto corresponde al método "mostrarLibros" que tenías, corregido para buscar por id_libro.
    function showDetalleLibro($id_libro=null) {
        // 1. Verifica el parámetro obligatorio (id_libro)
        if (empty($id_libro) || !is_numeric($id_libro)) {
            $this->vista->mostrarError("Debe indicar el ID del libro.");
            return; // Termina la ejecución
        }
        
        $libro=$this->modelo->obtenerLibroPorId($id_libro);
        
        // 2. Pide el detalle del libro al Modelo (incluyendo el nombre del autor)
        $libro = $this->modelo->obtenerLibroPorId($id_libro);

        // 3. Muestra el resultado
        if (empty($libro)) {
            $this->vista->mostrarError("No se encontró el libro con ID: " . $id_libro);
        } else {
            $this->vista->mostrarDetalleLibro($libro); // Nuevo método en la Vista
        }
    }

    public function buscarLibro() {
        $titulo_buscado = $_GET['titulo_libro'] ?? null;

        if (empty($titulo_buscado)) {
            $this->vista->mostrarError("Debe ingresar un título para buscar.");
            return;
        }
        
        $libro = $this->modelo->buscarLibroPorTitulo($titulo_buscado);

        if ($libro) {
            // Muestra la vista de detalle del libro
            $this->vista->mostrarDetalleLibro($libro);
        } else {
            $this->vista->mostrarError("No se encontró el libro con el título: '{$titulo_buscado}'.");
        }
    }
}
?>
