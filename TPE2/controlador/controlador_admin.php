<?php 
require_once 'TPE2/modelo/libros_modelo.php';
require_once 'TPE2/modelo/autores_modelo.php';
require_once 'TPE2/vista/admin_vista.phtml';

class ControladorAdministrador{
    private $vista;
    private $librosmodelo;
    private $autoresmodelo;

    public function __construct(){
        $this->vista=new AdminVista;
        $this->librosmodelo= new LibrosModelo();
        $this->autoresmodelo=new AutorModelo();

    }
    public function showPanelAdmin(){
        $libros=$this-> librosmodelo-> obtenerLibros();
        $autores=$this-> autoresmodelo-> obtenerTodosLosAutores();

        $this->vista->mostrarFormularioEdicion($autores, $libros);
    }
}