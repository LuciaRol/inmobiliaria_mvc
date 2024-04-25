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
    // Ruta al archivo CSV donde se almacenarán las viviendas
    $archivoCSV = 'viviendas.csv';
    // Si la solicitud es POST, procesar el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mensaje_error = Vivienda::validarCampos(
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


        
        // Crear una instancia de Vivienda con los datos del formulario
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
        // Revisamos que la foto no exceda los 100kb
        try {
            $vivienda->validarFoto($_FILES['archivo'] ?? null);
        } catch (\Exception $e) {
            ?>
            <!-- En caso de error en la validación de la foto, mostrar el mensaje de error -->
            <?php echo $e->getMessage(); ?>
            <br>
            <button onclick="history.go(-1);">Volver</button> <!-- Agregar un botón para volver atrás -->
            <?php
            return;
        }
        
        // Crear una instancia de Vivienda y procesar el formulario para tener la variable en Vivienda Controller y hacer las validaciones y 
        // saneamiento también en la clase
        Vivienda::procesarFormulario();
        // Si todo va correctamente, se almacenará la información en el archivo CSV
        $fp = fopen($archivoCSV, 'a');
            // Si no se pudo abrir el archivo, muestra un mensaje de error
        if (!$fp) {
            echo "Error al abrir el archivo CSV para escritura.";
        return;
        }
        // Escritura de la nueva vivienda en el archivo CSV
        fputcsv($fp, $vivienda->toArray());

        // Cierra el archivo después de escribir
        fclose($fp);
        

      
    }

    // Si es GET o hay errores, renderizar la página del formulario
    $pagina = new Pages();
    $pagina->render("nuevaVivienda");
    }



}
