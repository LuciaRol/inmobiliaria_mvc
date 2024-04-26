<?php
namespace Controllers;

use Lib\Pages;
use Models\Vivienda;
class DashboardController {
    public function mostrarDashboard():void {
        $pagina = new Pages();
        $pagina->render("dashboard");
    }
    
    public function mostrarNuevaVivienda():void {
        // Realizamos una comprobación de los camposObligatorios para asegurarnos que existen.         
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $mensaje_error = Vivienda::validarCamposObligatorios(
                $_POST['tipo'] ?? '',
                $_POST['zona'] ?? '',
                $_POST['direccion'] ?? '',
                $_POST['precio'] ?? '',
                $_POST['tamano'] ?? ''
            );
            
            if ($mensaje_error) {
                // Si hay errores en los campos, mostrar el mensaje de error
                echo $mensaje_error;
                // aquí falta el botón de volver    
                return;
            }


              // Revisamos que la foto no exceda los 100kb
            try {
                Vivienda::validarFoto($_FILES['archivo'] ?? null);
            } catch (\Exception $e) {
                ?>
                <!-- En caso de error en la validación de la foto, mostrar el mensaje de error -->
                <?php echo $e->getMessage(); ?>
                <br>
                <button onclick="history.go(-1);">Volver</button> <!-- Agregar un botón para volver atrás -->
                <?php
                return;
            }
        
        }

        // Si es GET o hay errores, renderizar la página del formulario
        $pagina = new Pages();
        $pagina->render("nuevaVivienda");
        }

    }
