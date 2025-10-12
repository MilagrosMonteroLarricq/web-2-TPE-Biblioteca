<?php
include_once 'modelo.php';
include_once 'vista.php';

class ControladorAutor{

    private $modelo;
    private $vista;

    function __construct(){
        $this->modelo = new AutorModelo();
        $this->vista = new AutorVista();  
    }


    function showLibrosByAutor(){

        // verifica datos obligatorios
        if (!isset($_GET['id_autor']) || empty($_GET['id_autor'])) { 
            $this->vista->mostrarError("Debe indicar el ID del autor."); //Usar $this->vista
            die();
        }

        $id_autor = $_GET['id_autor'];

        //Pide los datos al Modelo
        $libros = $this->modelo->obtenerLibrosPorAutor($id_autor); 

        // Si no hay libros, muestra un mensaje o error
        if (empty($libros)) {
            $this->vista->mostrarError("No se encontraron libros para el autor con ID: " . $id_autor);
            die();
        }
        
        // Muestra los resultados (nota el cambio de parámetro a $libros)
        $this->vista->mostrarListadoLibros($id_autor, $libros); 

    }
    
    // Listado de Categorías (Todos los Autores)
    function showAutores() {
        $autores = $this->modelo->obtenerTodosLosAutores(); // Nuevo método en el Modelo
        $this->vista->mostrarListadoAutores($autores); // Nuevo método en la Vista
    }
}
?>