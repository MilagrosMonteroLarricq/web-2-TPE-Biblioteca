<?php
include_once 'TPE2/modelo/autores_modelo.php'; 
include_once 'TPE2/vista/autores_vista.phtml'; 
include_once 'TPE2/controlador/seguridad_controlador.php';
include_once 'TPE2/middlewares/auth.helper.php';

class ControladorAutor{

    private $modelo;
    private $vistaAutor;

    function __construct(){
        $this->modelo = new AutorModelo();
        $this->vistaAutor = new AutorVista();
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

    // mostrar fomulario de Alta
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

        if(empty($nombre) || empty($apellido)){
            $this->vistaAutor->mostrarError("Faltan campos obligatorios (Nombre y Apellido). ");
            return;
        }

        //llama al modelo
        $this->modelo->agregarAutor($nombre, $apellido, $nacionalidad);

        header("Location: route.php?action=listarAutores");
        exit;
    }

    // mostrar el formulario de edicion
    function showFormEditarAutor($id_autor = null){
        AuthHelper::checkLoggedIn();

        if(empty($id_autor)){
            $this->vistaAutor->mostrarError("ID de autor no especificado para edición.");
            return;
        }

        $autor = $this->modelo->obtenerAutorPorId($id_autor);

        if ($autor){
            $this->vistaAutor->mostrarFormularioEdicion($autor);
        } else {
            $this->vistaAutor->mostrarError("Autor a editar no encontrado.");
        }
    }

    //procesar el formulario de edicion
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

        // Llamamos al modelo (Tu modelo SÓLO acepta 4 parámetros: id, nombre, apellido, nacionalidad)
        $this->modelo->editarAutor($id, $nombre, $apellido, $nacionalidad);

        header("Location: route.php?action=listarAutores");
        exit;
    }
    
    // 5. Eliminar autor (Baja)
    function eliminarAutor($id_autor = null) { 
        AuthHelper::checkLoggedIn();       
        if (empty($id_autor) || !is_numeric($id_autor)) {
            $this->vistaAutor->mostrarError("Debe indicar un ID de autor válido para eliminar.");
            return;
        }
        
        $this->modelo->eliminarAutor($id_autor);

        header("Location: route.php?action=listarAutores");
        exit;
    }
}
?>