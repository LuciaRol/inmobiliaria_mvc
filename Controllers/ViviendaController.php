<?php

namespace Controllers;

use Models\Vivienda;
use Lib\Pages;

class ViviendaController {
    public function mostrarDatos() {
        $tipo = $_POST['tipo'] ?? 'No especificado';
        $zona = $_POST['zona'] ?? 'No especificado';
        $direccion = $_POST['direccion'] ?? 'No especificado';
        $dormitorios = $_POST['dormitorios'] ?? 'No especificado';
        $precio = $_POST['precio'] ?? 'No especificado';
        $tamano = $_POST['tamano'] ?? 'No especificado';
        $observaciones = $_POST['mensaje'] ?? 'No especificado';
        $archivo = $_FILES['archivo'] ?? null;
    
        
        $fotoData = $this -> validarFoto($archivo);
        $beneficio = $this -> calcularBeneficio($zona, $tamano);
    
        // Define los datos
        $data = [
            'tipo' => $tipo,
            'zona' => $zona,
            'direccion' => $direccion,
            'dormitorios' => $dormitorios,
            'precio' => $precio,
            'tamano' => $tamano,
            'observaciones' => $observaciones,
            'imagePath' => $fotoData['imagePath'], // Ruta de la foto si se cargó correctamente
            'beneficio' => $beneficio, // Porcentaje de beneficio calculado
            'error' => $fotoData['error'] ?? null // Mensaje de error de la carga de la foto
        ];
    
        return $data;
    }
    

    function calcularBeneficio($zona, $tamano):string {
        $porcentajesBeneficio = [
            'Centro' => ['Menos de 100 m2' => 0.30, 'Más de 100 m2' => 0.35],
            'Zaidín' => ['Menos de 100 m2' => 0.25, 'Más de 100 m2' => 0.28],
            'Chana' => ['Menos de 100 m2' => 0.22, 'Más de 100 m2' => 0.25],
            'Albaicín' => ['Menos de 100 m2' => 0.20, 'Más de 100 m2' => 0.35],
            'Sacromonte' => ['Menos de 100 m2' => 0.22, 'Más de 100 m2' => 0.25],
            'Realejo' => ['Menos de 100 m2' => 0.25, 'Más de 100 m2' => 0.28]
        ];
    
        // Verifica si la zona está definida
        if (isset($porcentajesBeneficio[$zona])) {
            // Determina el beneficio según el tamaño de la propiedad
            if ($tamano <= 100) {
                return $porcentajesBeneficio[$zona]['Menos de 100 m2'];
            } else {
                return $porcentajesBeneficio[$zona]['Más de 100 m2'];
            }
        } else {
            // Si la zona no está definida, devuelve un mensaje de error
            return "Zona no válida";
        }
    }

    function validarFoto($archivo) {
        $data = [];
    
        if ($archivo && $archivo['error'] == UPLOAD_ERR_OK) {
            // Comprueba el tamaño de la foto
            if ($archivo['size'] > 100 * 1024) { 
                $data['error'] = "El tamaño de la foto no debe exceder los 100KB.";
            } else {
                $uploadDir = __DIR__ . '/../Views/fotos/';
                $uploadFile = $uploadDir . basename($archivo['name']);
                
                // Comprueba si existe la carpeta donde se guardan las fotos.
                // Si no existe, se crea el directorio.
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