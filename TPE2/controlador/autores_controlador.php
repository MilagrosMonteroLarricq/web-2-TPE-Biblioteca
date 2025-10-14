<?php
include_once 'TPE2/controlador/autores_controlador.php';
include_once 'TPE2/vista/autores_vista.phtml';
include_once 'TPE2/vista/libros_vista.phtml';

class ControladorAutor{

    private $modelo;
    private $vista;

    function __construct(){
        $this->modelo = new AutorModelo();
        $this->vista = new AutorVista();  
    }

    // (B) Listado de categorías (autores)
    function showAutores() {
        $autores = $this->modelo->obtenerTodosLosAutores(); // Nuevo método en el Modelo
        $this->vista->mostrarListadoAutores($autores); // Nuevo método en la Vista
    }

    // (B) Listado de ítems por categoría
    function showLibrosByAutor(){

        $id_autor = $_GET['id_autor'];

        //Pide los datos al Modelo
        $libros = $this->modelo->obtenerLibrosPorAutor($id_autor);

        // verifica datos obligatorios
        if (!isset($_GET['id_autor']) || empty($_GET['id_autor'])) { 
            $this->vista->mostrarError("Debe indicar el ID del autor."); //Usar $this->vista
            return;
        }
        
        // Si no hay libros, muestra un mensaje o error
        if (empty($libros)) {
            $this->vista->mostrarError("No se encontraron libros para el autor con ID: " . $id_autor);
        } else{
        // Muestra los resultados (nota el cambio de parámetro a $libros)
        $this->vista->mostrarLibros($libros); 
        }
    }
}
?>