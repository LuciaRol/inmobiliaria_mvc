<?php
namespace Controllers;

use Lib\Pages;

class DashboardController {
    public function mostrarDashboard() {
        $pagina = new Pages();
        $pagina->render("dashboard");
    }
}
