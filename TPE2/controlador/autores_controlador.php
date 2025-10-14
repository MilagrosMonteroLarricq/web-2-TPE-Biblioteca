<?php
include_once 'TPE2/modelo/modelo.php';
include_once 'TPE2/vista/vista.php';


class ControladorAutor{
 
    private $modelo;
    private $vistaAutor;  // Usado para listar autores y errores
    private $vistaLibros; // Usado para mostrar la tabla de libros

    function __construct(){
        $this->modelo = new AutorModelo();
        //  Creamos instancias de ambas vistas
        $this->vistaAutor = new AutorVista();   
        $this->vistaLibros = new LibrosVista(); 
    }

    // (B) Listado de categorías (autores)
    function showAutores() {
        $autores = $this->modelo->obtenerTodosLosAutores(); 
        $this->vistaAutor->mostrarListadoAutores($autores); 
    }

    // (B) Listado de ítems por categoría
    //  EL ID VIENE DEL ROUTER COMO ARGUMENTO
    function showLibrosByAutor($id_autor = null){

        // 1. Verificar ID
        if (empty($id_autor) || !is_numeric($id_autor)) { 
            // Usamos la vista de autor para mostrar el error de parámetro
            $this->vistaAutor->mostrarError("Debe indicar el ID del autor."); 
            return;
        }

        // 2. Pide los datos al Modelo
        $libros = $this->modelo->obtenerLibrosPorAutor($id_autor);
        
        // 3. Obtener el nombre del autor para el título
        $autor = $this->modelo->obtenerLibrosPorAutor($id_autor); 

        $titulo = "Libros Filtrados";
        if ($autor) {
            $titulo = "Libros de: " . $autor->nombre . " " . $autor->apellido;
        }

        // 4. Mostrar la Vista
        if (empty($libros)) {
            // Si no hay libros, muestra un mensaje o error
            $this->vistaAutor->mostrarError("No se encontraron libros para el autor con ID: " . $id_autor);
        } else{
            //  USAMOS LA VISTA DE LIBROS para mostrar la tabla de ítems
            $this->vistaLibros->obtenerTodosLosAutores($libros, $titulo); 
        }
    }
}
?>