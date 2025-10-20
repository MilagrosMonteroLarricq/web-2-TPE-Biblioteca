<?php
// incluye el modelo de autores y la vista específica de autores
include_once 'TPE2/modelo/autores_modelo.php'; 
include_once 'TPE2/vista/autores_vista.phtml'; 
include_once 'TPE2/controlador/seguridad_controlador.php';
include_once 'TPE2/middlewares/auth.helper.php';

// necesarias para listar los ITEMS (libros)
include_once 'TPE2/modelo/libros_modelo.php'; 
include_once 'TPE2/vista/libros_vista.phtml'; 

class ControladorAutor{

    private $modeloAutor; 
    private $modeloLibros; 
    private $vistaAutor;
    private $vistaLibros;

    function __construct() {
        // inicializa los Modelos y las Vistas
        $this->modeloAutor = new AutorModelo();
        $this->modeloLibros = new LibrosModelo(); 
        $this->vistaAutor = new AutorVista();
        $this->vistaLibros = new LibrosVista(); 
    }

    // (B) Listado de categorías (autores)
    function showAutores() {
        $autores = $this->modeloAutor->obtenerTodosLosAutores();
        $this->vistaAutor->mostrarListadoAutores($autores);
    }

    // (B) Listado de items por categoria
    function showDetalleAutor($id_autor = null) {
        // 1. Verificar ID
        if (empty($id_autor) || !is_numeric($id_autor)) {
            $this->vistaAutor->mostrarError("Debe indicar el ID del autor."); 
            return;
        }

        // 2. obtener el autor (la categoría)
        $autor = $this->modeloAutor->obtenerAutorPorId($id_autor); 

        if (!$autor) {
            $this->vistaAutor->mostrarError("Autor no encontrado con ID: " . $id_autor);
            return;
        } 

        // 3. obtener el listado de ITEMS (libros) de esa categoría (autor)
        // usamos el método que agregamos al LibrosModelo
        $libros = $this->modeloLibros->obtenerLibrosPorAutor($id_autor); 

        // 4. USAMOS LA VISTA DE LIBROS para mostrar la tabla de ítems
        // se envía la lista de libros y el objeto autor para usar su nombre en el título.
        $this->vistaLibros->mostrarLibros($libros, $autor);
    }

    public function buscarAutor() {
        $nombre_buscado = $_GET['nombre_autor'] ?? null;
        if (empty($nombre_buscado)) {
            $this->vistaAutor->mostrarError("Debe ingresar un nombre de autor para buscar.");
            return;
        }

        $autor = $this->modeloAutor->buscarAutorPorNombre($nombre_buscado);
        
        if ($autor) {
            $this->vistaAutor->mostrarDetalleAutor($autor);
        } else {
            $this->vistaAutor->mostrarError("No se encontró el autor con el nombre: '{$nombre_buscado}'.");
        }
    }

    // mostrar fomulario de Alta - Protegido por AuthHelper
    function showFormAgregarAutor(){
        AuthHelper::checkLoggedIn();
        $this->vistaAutor->mostrarFormularioAlta();
    }

    // procesar el formulario de Alta
    function agregarAutor(){
        AuthHelper::checkLoggedIn();
        $nombre = $_POST['nombre'] ?? null;
        $apellido = $_POST['apellido'] ?? null;
        $nacionalidad = $_POST['nacionalidad'] ?? null;
        
        if (empty($nombre) || empty($apellido)) {
            $this->vistaAutor->mostrarError("Faltan campos obligatorios (Nombre y Apellido).");
            return;
        }

        $this->modeloAutor->agregarAutor($nombre, $apellido, $nacionalidad);
        header("Location: route.php?action=listarAutores");
        exit;
    }

    // mostrar el formulario de edicion - Protegido por AuthHelper
    function showFormEditarAutor($id_autor = null) {
        AuthHelper::checkLoggedIn();
        if (empty($id_autor)) {
            $this->vistaAutor->mostrarError("ID de autor no especificado para edición.");
            return;
        }
        
        $autor = $this->modeloAutor->obtenerAutorPorId($id_autor);
        if ($autor) {
            $this->vistaAutor->mostrarFormularioEdicion($autor);
        } else {
            $this->vistaAutor->mostrarError("Autor a editar no encontrado.");
        }
    }
    
    // procesar el formulario de edicion
    function editarAutor() {
        AuthHelper::checkLoggedIn();
        $id = $_POST['id_autor'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $apellido = $_POST['apellido'] ?? null;
        $nacionalidad = $_POST['nacionalidad'] ?? null;

        if (empty($id) || empty($nombre) || empty($apellido)) {
            $this->vistaAutor->mostrarError("Faltan datos obligatorios para la edición.");
            return;
        }

        $this->modeloAutor->editarAutor($id, $nombre, $apellido, $nacionalidad);
        header("Location: route.php?action=listarAutores");
        exit;
    }

    // 5. Eliminar autor (Baja) - Protegido por AuthHelper
    function eliminarAutor($id_autor = null) {
        AuthHelper::checkLoggedIn();
        if (empty($id_autor) || !is_numeric($id_autor)) {
            $this->vistaAutor->mostrarError("Debe indicar un ID de autor válido para eliminar.");
            return;
        }
        
        $this->modeloAutor->eliminarAutor($id_autor);
        header("Location: route.php?action=listarAutores");
        exit;
    }
}
?>