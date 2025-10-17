<?php
include_once 'TPE2/modelo/autores_modelo.php'; 
include_once 'TPE2/vista/autores_vista.phtml'; 
include_once 'TPE2/controlador/seguridad_controlador.php';

class ControladorAutor{

    private $modelo;
    private $vistaAutor;  // Usado para listar autores y errores
    PRIVATE $seguridad;

    function __construct(){
        $this->modelo = new AutorModelo();
        $this->vistaAutor = new AutorVista();
        $this->seguridad = new ControladorSeguridad();
    }

    // (B) Listado de categorías (autores)
    function showAutores() {
        $autores = $this->modelo->obtenerTodosLosAutores(); 
        $this->vistaAutor->mostrarListadoAutores($autores); 
    }

    // (B) Listado de ítems por categoría
    //  EL ID VIENE DEL ROUTER COMO ARGUMENTO
    function showDetalleAutor($id_autor = null){

        // 1. Verificar ID
        if (empty($id_autor) || !is_numeric($id_autor)) { 
            // Usamos la vista de autor para mostrar el error de parámetro
            $this->vistaAutor->mostrarError("Debe indicar el ID del autor."); 
            return;
        }

        // 2. Obtener el nombre del autor para el título
        $autor = $this->modelo->obtenerAutorPorId($id_autor); 

        // 4. Mostrar la Vista
        if (!$autor) {
            // Si no hay libros, muestra un mensaje o error
            $this->vistaAutor->mostrarError("autor no encontrado con ID: " . $id_autor);
        } else{
            //  USAMOS LA VISTA DE LIBROS para mostrar la tabla de ítems
            $this->vistaAutor->mostrarDetalleAutor($autor); 
        }
    }

    public function buscarAutor() {
        $nombre_buscado = $_GET['nombre_autor'] ?? null;

        if (empty($nombre_buscado)) {
            $this->vistaAutor->mostrarError("Debe ingresar un nombre de autor para buscar.");
            return;
        }

        // 1. Busca el autor por nombre/apellido. El modelo retorna el objeto autor si lo encuentra.
        $autor = $this->modelo->buscarAutorPorNombre($nombre_buscado);

        if ($autor) {
            // 2. Éxito: Muestra la vista de detalle del autor
            $this->vistaAutor->mostrarDetalleAutor($autor);
        } else {
            // 3. Fallo: Muestra un mensaje de error
            $this->vistaAutor->mostrarError("No se encontró el autor con el nombre: '{$nombre_buscado}'.");
        }
    }
    
    function agregarAutor(){
        
    }
}
?>