<?php

namespace Models;

class Vivienda {
    public string $tipo;
    public string $zona;
    public string $direccion;
    public string $dormitorios;
    public string $precio;
    public string $tamano;
    public array $extras = [];
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
    public function getExtras(): array {
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
   
    // Método para procesar los datos del formulario y devolver una instancia de Vivienda
    public static function procesarFormulario() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tipo = $_POST['tipo'] ?? '';
            $zona = $_POST['zona'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $dormitorios = $_POST['dormitorios'] ?? '';
            $precio = $_POST['precio'] ?? '';
            $tamano = $_POST['tamano'] ?? '';
            // Procesar los extras utilizando la función procesarExtras()
            $extras = self::procesarExtras($_POST);
            $foto = $_FILES['archivo']['name'] ?? '';
            $observaciones = $_POST['mensaje'] ?? '';
            
            // Revisamos los campos obligatorios en el controlador y aquí, por si se llamase mediante otro proceso 
            // que no fuera el motivo principal del programa
            $mensaje_error = self::validarCamposObligatorios($tipo, $zona, $direccion, $precio, $tamano);
            if ($mensaje_error) {
                 return $mensaje_error;
            }
            else{
                $vivienda = new Vivienda($tipo, $zona, $direccion, $dormitorios, $precio, $tamano, $extras, $foto, $observaciones);
                return $vivienda;
                }
            } 
        return null; // Si no se crea una nueva instancia de Vivienda, devuelve null
        }
    // En Validar Campos revisamos que los campos requeridos son introducidos y que precio y tamaño son numéricos para que funcione correctamente la 
    // fórmula de cálculo del beneficio
    public static function validarCamposObligatorios($tipo, $zona, $direccion, $precio, $tamano) {
        $campos = ['tipo' => $tipo, 'zona' => $zona, 'direccion' => $direccion, 'precio' => $precio, 'tamano' => $tamano];
        $campos_vacios = [];
        $campos_no_numericos = [];
    
        foreach ($campos as $nombre => $valor) {
            if (empty($valor)) {
                $campos_vacios[] = $nombre;
            } elseif ($nombre === 'precio' && filter_var($valor, FILTER_VALIDATE_INT) === false) { // en este campo hace doble revisión que el campo sea numérico, además del saneamiento previo
                $campos_no_numericos[] = $nombre;
            } elseif ($nombre === 'tamano' && filter_var($valor, FILTER_VALIDATE_INT) === false) { // en este campo hace doble revisión que el campo sea numérico, además del saneamiento previo
                $campos_no_numericos[] = $nombre;
            }
        }
    
        $errores = [];
    
        if (!empty($campos_vacios)) {
            $errores[] = "No has introducido el/los siguiente(s) campo(s): " . implode(', ', $campos_vacios);
        }
    
        if (!empty($campos_no_numericos)) {
            $errores[] = "Los siguientes campos deben ser numéricos: " . implode(', ', $campos_no_numericos);
        }
    
        return !empty($errores) ? implode('<br>', $errores) : null;
    }
    
    public function cargarFoto($archivo) {
        if ($archivo && $archivo['error'] == UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../Views/fotos/';
            $uploadFile = $uploadDir . basename($archivo['name']);
    
            // Comprueba si existe la carpeta donde se guardan las fotos.
            // Si no existe, se crea el directorio.
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
    
            if (move_uploaded_file($archivo['tmp_name'], $uploadFile)) {
                return 'Views/fotos/' . htmlspecialchars(basename($archivo['name']));
            }
        }
        return null; // Retorna null si no se pudo cargar la foto
    }

    public function validarFoto($archivo) {
        if ($archivo && $archivo['error'] == UPLOAD_ERR_OK) {
            // Comprueba el tamaño de la foto
            if ($archivo['size'] > 100 * 1024) { 
                // Lanzar una excepción si el tamaño excede el límite
                throw new \Exception("El tamaño de la foto excede los 100KB.");
            }
        } else {
        }
    }

    public static function procesarExtras($post) {
        $extras = [];

        // Verificar si cada checkbox está marcado y agregar el valor correspondiente al array de extras
        if (isset($post['piscina'])) {
            $extras[] = $post['piscina'];
        }
        if (isset($post['jardin'])) {
            $extras[] = $post['jardin'];
        }
        if (isset($post['garaje'])) {
            $extras[] = $post['garaje'];
        }

        return $extras;
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
    // Función para guardar el csv
    public function toArray() {

        $extrasString = implode('-', $this->extras);
        return [
            $this->tipo,
            $this->zona,
            $this->direccion,
            $this->dormitorios,
            $this->precio,
            $this->tamano,
            $extrasString, // Convertir el array de extras a una cadena separada por -
            $this->foto,
            $this->observaciones
        ];
    }
    
}
?>
