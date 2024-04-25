<?php

namespace Controllers;

use Models\Vivienda;
use Lib\Pages;

class ViviendaController {
    public     function mostrarDatos() {
        $vivienda = Vivienda::procesarFormulario();
        $fotoData = $vivienda->cargarFoto($_FILES['archivo'] ?? null);
        $beneficio = $vivienda->calcularBeneficio($vivienda->getZona(), $vivienda->getTamano());
    
        // Define los datos
        $data = [
            'tipo' => $vivienda->getTipo(),
            'zona' => $vivienda->getZona(),
            'direccion' => $vivienda->getDireccion(),
            'dormitorios' => $vivienda->getDormitorios(),
            'precio' => $vivienda->getPrecio(),
            'tamano' => $vivienda->getTamano(),
            'observaciones' => $vivienda->getObservaciones(),
            'imagePath' => $fotoData, // Ruta de la foto si se cargó correctamente
            'beneficio' => $beneficio, // Porcentaje de beneficio calculado
            'error' => $fotoData['error'] ?? null // Mensaje de error de la carga de la foto
        ];
    
        return $data;
    }
   

}