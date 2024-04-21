<?php

namespace Controllers;

use Models\Vivienda;
use Lib\Pages;

class ViviendaController{
    public function mostrarVivienda(){
        $pagina = new Pages();
        $pagina->render("nuevaVivienda");
    }
}