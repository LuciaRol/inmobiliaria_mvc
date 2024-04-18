<?php 
namespace Controllers;
use Controllers\FrontController;
use Lib\Pages;



class DashboardController {

    function mostrarDashboard(){
        /* $pagina = new Pages;
        $pagina->render('index'); */
        echo "
        <h1>INMOBILIARIA EXTRAORDINARIA<h1/>
        <h2>- Plataforma del empleado -<h2/>
        ";

        /* <a href="<?=BASE_URL?>index.php?controller=Baraja&action=mostrarBaraja">Ingresa una nueva vivienda a la base de datos</a> */
    }
}