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
                ?>
                <br>
                <button onclick="history.go(-1);">Volver</button>
                <?php
                return; // para que no siga el proceso
            }

              // Revisamos que la foto no exceda los 100kb
            $error = Vivienda::validarFoto($_FILES['archivo'] ?? null);
            if ($error !== null) {
                // Mostrar el mensaje de error y el botón para volver atrás
                echo $error;
                ?>
                <br>
                <button onclick="history.go(-1);">Volver</button>
                <?php
                return; // para que no siga el proceso
            }
    
        }

        // Si es GET o hay errores, renderizar la página del formulario
        $pagina = new Pages();
        $pagina->render("nuevaVivienda");
        }

    }
