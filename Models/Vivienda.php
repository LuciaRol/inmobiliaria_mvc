<?php

namespace Models;


class Vivienda {
    public string $tipo;
    public string $zona;
    public string $direccion;
    public string $dormitorios;
    public string $precio;
    public string $tamano;
    public $extras = [];
    public string $foto;
    public string $observaciones;
    

    public function __construct($tipo, $zona, $direccion, $dormitorios, $precio, $tamano, $extras, $foto, $observaciones) {
        $this->tipo = $tipo;
        $this->zona = $zona;
        $this->direccion = $direccion;
        $this->dormitorios = $dormitorios;
        $this->precio = $precio;
        $this->tamano = $tamano;
        $this->extras = $extras;
        $this->foto = $foto;
        $this->observaciones = $observaciones;
    }

    // GETTERS Y SETTERS
    public function getTipo() {
        return $this->tipo;
    }

	public function getZona() {
        return $this->zona;
    }

	public function getDireccion() {
        return $this->direccion;
    }

	public function getDormitorios() {
        return $this->dormitorios;
    }

	public function getPrecio() {
        return $this->precio;
    }

	public function getTamano() {
        return $this->tamano;
    }

	public function getFoto() {
        return $this->foto;
    }

	public function getObservaciones() {
        return $this->observaciones;
    }

    public function setTipo(string $tipo): void {
        $this->tipo = $tipo;
    }

	public function setZona(string $zona): void {
        $this->zona = $zona;
    }

	public function setDireccion(string $direccion): void {
        $this->direccion = $direccion;
    }

	public function setDormitorios(string $dormitorios): void {
        $this->dormitorios = $dormitorios;
    }

	public function setPrecio(string $precio): void {
        $this->precio = $precio;
    }

	public function setTamano(string $tamano): void {
        $this->tamano = $tamano;
    }

	public function setFoto(string $foto): void {
        $this->foto = $foto;
    }

	public function setObservaciones(string $observaciones): void {
        $this->observaciones = $observaciones;
    }
    
    // Método que genera un nuevo archivo php para guardar los datos introducidos
    public function generarArchivo() {
        $codigo = '<?php' . PHP_EOL;
        $codigo .= '$vivienda = new Vivienda(';
        $codigo .= "'" . $this->tipo . "', ";
        $codigo .= "'" . $this->zona . "', ";
        $codigo .= "'" . $this->direccion . "', ";
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
    $zona = $_POST['direccion'] ?? '';
    $dormitorios = $_POST['dormitorios'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $tamano = $_POST['tamano'] ?? '';
    $extras = $_POST['extra'] ?? [];
    $foto = $_FILES['archivo']['name'] ?? '';
    $observaciones = $_POST['mensaje'] ?? '';
    

    $vivienda = new Vivienda($tipo, $zona, $direccion, $dormitorios, $precio, $tamano, $extras, $foto, $observaciones);
    
    // Genera la nueva vivienda y la guarda en un archivo
    $codigoPHP = $vivienda->generarArchivo();
    $nombreArchivo = 'registro.php';
    file_put_contents($nombreArchivo, $codigoPHP);
    


    
    
}



