<?php

namespace Models;


class Vivienda {
    public $tipo;
    public $zona;
    public $dormitorios;
    public $precio;
    public $tamano;
    public $extras = [];
    public $foto;
    public $observaciones;
    

    public function __construct($tipo, $zona, $dormitorios, $precio, $tamano, $extras, $foto, $observaciones) {
        $this->tipo = $tipo;
        $this->zona = $zona;
        $this->dormitorios = $dormitorios;
        $this->precio = $precio;
        $this->tamano = $tamano;
        $this->extras = $extras;
        $this->foto = $foto;
        $this->observaciones = $observaciones;
    }
    
    // Método que genera un nuevo archivo php para guardar los datos introducidos
    public function generarArchivo() {
        $codigo = '<?php' . PHP_EOL;
        $codigo .= '$vivienda = new Vivienda(';
        $codigo .= "'" . $this->tipo . "', ";
        $codigo .= "'" . $this->zona . "', ";
        $codigo .= "'" . $this->dormitorios . "', ";
        $codigo .= "'" . $this->precio . "', ";
        $codigo .= "'" . $this->tamano . "', ";
        $codigo .= "['" . implode("', '", $this->extras) . "'], ";
        $codigo .= "'" . $this->foto . "', ";
        $codigo .= "'" . $this->observaciones . "');";
        return $codigo;
    }
}

// Procesamiento de los datos recogidos en el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'] ?? '';
    $zona = $_POST['zona'] ?? '';
    $dormitorios = $_POST['dormitorios'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $tamano = $_POST['tamano'] ?? '';
    $extras = $_POST['extra'] ?? [];
    $foto = $_FILES['archivo']['name'] ?? '';
    $observaciones = $_POST['mensaje'] ?? '';
    

    $vivienda = new Vivienda($tipo, $zona, $dormitorios, $precio, $tamano, $extras, $foto, $observaciones);
    
    // Genera la nueva vivienda y la guarda en un archivo
    $codigoPHP = $vivienda->generarArchivo();
    $nombreArchivo = 'Vivienda.php';
    file_put_contents($nombreArchivo, $codigoPHP);
    


    
    
}




