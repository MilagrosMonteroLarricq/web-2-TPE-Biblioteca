<?php
include_once 'TPE2/vista/home.phtml';

class ControladorHome {
    private $vista;

    public function __construct() {
        $this->vista = new HomeVista();
    }

    public function showHome() {
        $this->vista->showHome();
    }
}
?>