<?php

namespace Controllers;

use Models\Vivienda;
use Lib\Pages;

class ViviendaController {
    public function mostrarViviendaData() {
        // Suponemos que el archivo fue enviado correctamente
        $tipo = $_POST['tipo'] ?? 'No especificado';
        $zona = $_POST['zona'] ?? 'No especificado';
        $direccion = $_POST['direccion'] ?? 'No especificado';
        $precio = $_POST['precio'] ?? 'No especificado';
        $tamano = $_POST['tamano'] ?? 'No especificado';
        $observaciones = $_POST['mensaje'] ?? 'No especificado';
        $archivo = $_FILES['archivo'] ?? null;

        $data = [
            'tipo' => $tipo,
            'zona' => $zona,
            'direccion' => $direccion,
            'precio' => $precio,
            'tamano' => $tamano,
            'observaciones' => $observaciones,
            'imagePath' => null
        ];

        if ($archivo && $archivo['error'] == UPLOAD_ERR_OK) {
            // Verificar el tamaño del archivo
            if ($archivo['size'] > 100 * 1024) { // 100KB en bytes
                $data['error'] = "El tamaño de la foto no debe exceder los 100KB.";
            } else {
                $uploadDir = __DIR__ . '/../Views/fotos/';
                $uploadFile = $uploadDir . basename($archivo['name']);
                
                // Verificar si el directorio de carga existe, si no, intentar crearlo
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                if (move_uploaded_file($archivo['tmp_name'], $uploadFile)) {
                    $imagePath = 'Views/fotos/' . htmlspecialchars(basename($archivo['name']));
                    $data['imagePath'] = $imagePath;
                }
            }
        } else {
            $data['error'] = "No se subió ninguna foto o el tamaño de la misma excedió los 100 kb.";
        }

        return $data;
    }

}