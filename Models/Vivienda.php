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

    // GETTERS
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

    public function getExtras():array {
        return $this->extras;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

    // SETTERS
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

    public function setExtras(array $extras): void {
        $this->extras = $extras;
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

    // Método para procesar los datos del formulario
    public static function procesarFormulario() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tipo = $_POST['tipo'] ?? '';
            $zona = $_POST['zona'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $precio = $_POST['precio'] ?? '';
            $tamano = $_POST['tamano'] ?? '';
            $foto = $_FILES['archivo']['name'] ?? '';
            $observaciones = $_POST['mensaje'] ?? '';
    
            // Validar los datos ingresados
            if (!empty($tipo) && !empty($zona) && !empty($direccion) && !empty($precio) && !empty($tamano)) {
                // Los datos son válidos, crear instancia de Vivienda
                $vivienda = new Vivienda($tipo, $zona, $direccion, '', $precio, $tamano, [], $foto, $observaciones);
                
                // Verificar si la instancia es válida
                if ($vivienda->esValida()) {
                    // La instancia es válida, puedes hacer lo que necesites aquí
                } else {
                    // La instancia no es válida, puedes manejar este caso como prefieras
                }
            } else {
                // Algunos campos obligatorios están vacíos, puedes manejar este caso como prefieras
            }
        }
    }
    public function esValida() {
        // Verificar si el precio es un número válido
        if (!is_numeric($this->precio)) {
            return false; // El precio no es válido
        }
    
        // Verificar si el tamaño es un número válido
        if (!is_numeric($this->tamano)) {
            return false; // El tamaño no es válido
        }
    
        return true;
    }
    
}

// Llamar al método para procesar el formulario
//Vivienda::procesarFormulario();

