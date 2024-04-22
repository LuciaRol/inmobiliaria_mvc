<?php
namespace Controllers;

use Lib\Pages;
use Models\Vivienda;
class DashboardController {
    public function mostrarDashboard() {
        $pagina = new Pages();
        $pagina->render("dashboard");
    }

    public function mostrarNuevaVivienda() {
    // Si la solicitud es POST, procesar el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Crear una instancia de Vivienda
        $vivienda = new Vivienda(
            $_POST['tipo'] ?? '',
            $_POST['zona'] ?? '',
            $_POST['direccion'] ?? '',
            $_POST['dormitorios'] ?? '',
            $_POST['precio'] ?? '',
            $_POST['tamano'] ?? '',
            $_POST['extra'] ?? [],
            $_FILES['archivo']['name'] ?? '',
            $_POST['mensaje'] ?? ''
        );

        // Validar la vivienda
        $errores = $this->validarVivienda($vivienda);

        // Si no hay errores, generar el archivo
        if (empty($errores)) {
            $codigoPHP = $vivienda->generarArchivo();
            $nombreArchivo = 'registro.php';
            file_put_contents($nombreArchivo, $codigoPHP);
            // Redireccionar a una página de éxito o mostrar un mensaje de éxito
            // header("Location: success.php");
            // exit;
        } else {
            // Mostrar los errores al usuario
            foreach ($errores as $error) {
                echo $error . '<br>';
            }
        }
    }

    // Si es GET o hay errores, renderizar la página del formulario
    $pagina = new Pages();
    $pagina->render("nuevaVivienda");
}

// Método para validar la vivienda
private function validarVivienda($vivienda) {
    $errores = [];

    // Ejemplo de validación para el tipo de vivienda
    if (empty($vivienda->getTipo())) {
        $errores[] = "El tipo de vivienda es obligatorio.";
    }

    // Aquí puedes agregar más validaciones para otros campos de la vivienda

    return $errores;
}
}
