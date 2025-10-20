<?php
// Incluimos el modelo y la vista
include_once 'TPE2/modelo/libros_modelo.php';
include_once 'TPE2/modelo/autores_modelo.php';
include_once 'TPE2/vista/libros_vista.phtml';

class ControladorLibros {
    private $modelo;
    private $vistaLibro;

    function __construct() {
        // Asumiendo que las clases Modelo y Vista existen en sus respectivos archivos
        $this->modelo = new LibrosModelo();
        $this->vistaLibro = new LibrosVista();
    }

    // (A) Listado de ítems: Muestra TODOS los libros.
    // Esto corresponde al método "mostrarAutores" que tenías, pero centrado en los Libros.
    function showLibros() {
        // Pide todos los libros al Modelo.
        // El Modelo debe devolver un array con todos los datos, incluyendo el nombre del autor.
        $libros = $this->modelo->obtenerLibros(); 
        
        if (empty($libros)) {
            $this->vistaLibro->mostrarError("No se encontraron libros en la biblioteca.");
        } else {
            // Muestra el listado completo
            $this->vistaLibro->mostrarLibros($libros);
        }
    }

    // (A) Detalle de ítem: Muestra un libro particular.
    // Esto corresponde al método "mostrarLibros" que tenías, corregido para buscar por id_libro.
    function showDetalleLibro($id_libro=null) {
        // 1. Verifica el parámetro obligatorio (id_libro)
        if (empty($id_libro) || !is_numeric($id_libro)) {
            $this->vistaLibro->mostrarError("Debe indicar el ID del libro.");
            return; // Termina la ejecución
        }
        
        $libro=$this->modelo->obtenerLibroPorId($id_libro);
        
        // 2. Pide el detalle del libro al Modelo (incluyendo el nombre del autor)
        $libro = $this->modelo->obtenerLibroPorId($id_libro);

        // 3. Muestra el resultado
        if (empty($libro)) {
            $this->vistaLibro->mostrarError("No se encontró el libro con ID: " . $id_libro);
        } else {
            $this->vistaLibro->mostrarDetalleLibro($libro); // Nuevo método en la Vista
        }
    }

    public function buscarLibro() {
        $titulo_buscado = $_GET['titulo_libro'] ?? null;

        if (empty($titulo_buscado)) {
            $this->vistaLibro->mostrarError("Debe ingresar un título para buscar.");
            return;
        }
        
        $libro = $this->modelo->buscarLibroPorTitulo($titulo_buscado);

        if ($libro) {
            // Muestra la vista de detalle del libro
            $this->vistaLibro->mostrarDetalleLibro($libro);
        } else {
            $this->vistaLibro->mostrarError("No se encontró el libro con el título: '{$titulo_buscado}'.");
        }
    }

    function showFormAgregarLibro(){
        AuthHelper::checkLoggedIn();
        $this->vistaLibro->mostrarFormularioAltaLibro();
    }

    function agregarLibro(){
        AuthHelper::checkLoggedIn();

        $titulo = $_POST['titulo'] ?? null;
        $genero = $_POST['genero'] ?? null;
        $anio_publicacion = $_POST['anio_publicacion'] ?? null;
        $editorial = $_POST['editorial'] ?? null;
        $id_autor = $_POST['id_autor'] ?? null;

        if(empty($titulo) || empty($genero) || empty($id_autor)){
            $this->vistaLibro->mostrarError("Faltan campos obligatorios (Título, Género e ID del autor). ");
            return;
        }

        //llama al modelo
        $this->modelo->agregarLibro($titulo, $genero, $anio_publicacion, $editorial, $id_autor);

        header("Location: route.php?action=admin");
        exit;
    }

    // mostrar el formulario de edicion
    function showFormEditarLibro($id_libro = null){
        AuthHelper::checkLoggedIn();

        if(empty($id_libro) || !is_numeric($id_libro)){
            $this->vistaLibro->mostrarError("ID de libro no especificado para edición.");
            return;
        }

        $libro = $this->modelo->obtenerLibroPorId($id_libro);

        if ($libro){
            $this->vistaLibro->mostrarFormularioEdicion($libro);
        } else {
            $this->vistaLibro->mostrarError("Libro a editar no encontrado.");
        }
    }


    // procesar el formulario de edicion
    function editarLibro() {
        AuthHelper::checkLoggedIn();
        $id_libro= $_POST['id_libro'] ?? null;
        $titulo = $_POST['titulo'] ?? null;
        $genero = $_POST['genero'] ?? null;
        $anio_publicacion = $_POST['anio_publicacion'] ?? null;
        $editorial = $_POST['editorial'] ?? null;
        $id_autor = $_POST['id_autor'] ?? null;

        if (empty($id_libro) || empty($titulo) || empty($genero)) {
            $this->vistaLibro->mostrarError("Faltan datos obligatorios para la edición.");
            return;
        }

        $this->modelo->editarLibro($id_libro, $titulo, $genero, $anio_publicacion, $editorial, $id_autor);
        header("Location: route.php?action=admin");
        exit;
    }

    // 5. Eliminar autor (Baja) - Protegido por AuthHelper
    function eliminarLibro($id_libro = null) {
        AuthHelper::checkLoggedIn();
        if (empty($id_libro) || !is_numeric($id_libro)) {
            $this->vistaLibro->mostrarError("Debe indicar un ID de libro válido para eliminar.");
            return;
        }

        $this->modelo->eliminarLibro($id_libro);
        header("Location: route.php?action=admin");
        exit;
    }

}
?>