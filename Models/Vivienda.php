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
    public function getTipo():string {
        return $this->tipo;
    }
    public function getZona():string {
        return $this->zona;
    }
    public function getDireccion(): string {
        return $this->direccion;
    }
    public function getDormitorios(): string {
        return $this->dormitorios;
    }
    public function getPrecio(): string {
        return $this->precio;
    }

    public function getTamano(): string {
        return $this->tamano;
    }
    public function getExtras(): array {
        return $this->extras;
    }
    public function getFoto(): string {
        return $this->foto;
    }
    public function getObservaciones(): string {
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
    public static function procesarFormulario(): mixed  { 
        // Es mixed ante la posibilidad que sea null, un string o Vivienda
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanear los campos antes de realizar cualquier validación
            $datosSaneados = self::sanearCampos(
                $_POST['tipo'] ?? '',
                $_POST['zona'] ?? '',
                $_POST['direccion'] ?? '',
                $_POST['dormitorios'] ?? '',
                $_POST['precio'] ?? '',
                $_POST['tamano'] ?? '',
                $_POST['mensaje'] ?? ''
            );
    
            // Validar los campos obligatorios utilizando los campos saneados para volver a verificar que existen
            $mensaje_error = self::validarCamposObligatorios(
                $datosSaneados['tipo'],
                $datosSaneados['zona'],
                $datosSaneados['direccion'],
                $datosSaneados['precio'],
                $datosSaneados['tamano']
            );
    
            if ($mensaje_error) {
                return $mensaje_error;
            } else {
                // Crear una nueva instancia de Vivienda utilizando los campos saneados
                $vivienda = new Vivienda(
                    $datosSaneados['tipo'],
                    $datosSaneados['zona'],
                    $datosSaneados['direccion'],
                    $datosSaneados['dormitorios'],
                    $datosSaneados['precio'],
                    $datosSaneados['tamano'],
                    self::procesarExtras($_POST),
                    $_FILES['archivo']['name'] ?? '',
                    $datosSaneados['observaciones']
                );
    
                // Llamar a la función para guardar la vivienda en el archivo CSV
                try {
                    self::guardarEnCSV($vivienda);
                    return $vivienda;
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            }
        }
        return null; // Si no se crea una nueva instancia de Vivienda, devuelve null
    }
    
    // En Validar Campos revisamos que los campos requeridos son introducidos y que precio y tamaño son numéricos para que funcione correctamente la 
    // fórmula de cálculo del beneficio
    public static function validarCamposObligatorios($tipo, $zona, $direccion, $precio, $tamano): ?string {
        $campos = ['tipo' => $tipo, 'zona' => $zona, 'direccion' => $direccion, 'precio' => $precio, 'tamano' => $tamano];
        $campos_vacios = [];
        $campos_no_numericos = [];
    
        foreach ($campos as $nombre => $valor) {
            if (!self::validar_requerido($valor)) {
                $campos_vacios[] = $nombre;
            } #elseif ($nombre === 'precio' && filter_var($valor, FILTER_VALIDATE_FLOAT) === false) { // en este campo hace doble revisión que el campo sea numérico, además del saneamiento previo
              #  $campos_no_numericos[] = $nombre;
            elseif ($nombre === 'tamano' && filter_var($valor, FILTER_VALIDATE_INT) === false) { // en este campo hace doble revisión que el campo sea numérico, además del saneamiento previo
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
    
    public static function sanearCampos($tipo, $zona, $direccion, $dormitorios, $precio, $tamano, $observaciones):array {
        // Revisar que los campos de texto libre como dirección y observaciones solo tengan caracteres del alfabeto y numéricos
        $direccion = self::filtrar_letras_o_numeros($direccion);
        $observaciones = self::filtrar_letras_o_numeros($observaciones);
        
        // Aplicar trim a todos los campos para eliminar espacios en blanco al inicio y al final
        $tipo = trim($tipo);
        $zona = trim($zona);
        $direccion = trim($direccion);
        $observaciones= trim($observaciones);
        
        
        // Sanear los números: eliminar todos los caracteres excepto los dígitos, signo más y signo menos.
        $precio = filter_var($precio, FILTER_SANITIZE_NUMBER_FLOAT); 
        $precio = floatval($precio);
        $tamano = filter_var($tamano, FILTER_SANITIZE_NUMBER_FLOAT);
        $tamano = floatval($tamano);
        $dormitorios = filter_var($dormitorios, FILTER_SANITIZE_NUMBER_FLOAT);
        $dormitorios = floatval($dormitorios);

        return ['tipo' => $tipo, 'zona' => $zona, 'direccion' => $direccion, 'precio' => $precio, 'tamano' => $tamano, 'dormitorios' => $dormitorios, 'observaciones' => $observaciones];
    }
    // Esta función se utiliza para verificar que se ha introducido datos
    public static function validar_requerido(string $texto):bool{
        return !(trim($texto)=='');
    }
    
    // valida 
    public static function filtrar_letras_o_numeros(string $texto): string {
        // Filtrar solo letras (mayúsculas y minúsculas), números y espacios, eliminando otros caracteres
        return preg_replace('/[^A-Za-z0-9\s]+/', '', $texto);
    }


    public function cargarFoto($archivo): ?string {
        if ($archivo && $archivo['error'] == UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../Fotos/';
            $uploadFile = $uploadDir . basename($archivo['name']);
    
            // Comprueba si existe la carpeta donde se guardan las fotos.
            // Si no existe, se crea el directorio.
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
    
            if (move_uploaded_file($archivo['tmp_name'], $uploadFile)) {
                return 'Fotos/' . htmlspecialchars(basename($archivo['name']));
            }
        }
        return null; // Retorna null si no se pudo cargar la foto
    }

    public static function validarFoto($archivo) {
        if ($archivo && $archivo['error'] == UPLOAD_ERR_OK) {
            // Comprueba el tamaño de la foto
            if ($archivo['size'] > 100 * 1024) { 
                // Devuelve un mensaje de error si el tamaño excede el límite
                return "El tamaño de la foto excede los 100KB.";
            }
        } else {
            // Devuelve un mensaje de error si hay un error al cargar la foto
            return "Error al cargar la foto.";
        }
        // Si la validación pasa, devuelve null (sin errores)
        return null;
    }

    public static function procesarExtras($post): array {
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
    //funcion que abre el archivo csv y realiza el guardado
    public static function guardarEnCSV(Vivienda $vivienda): void {
        // Ruta al archivo CSV donde se almacenarán las viviendas
        $archivoCSV = 'viviendas.csv';
    
        $fp = fopen($archivoCSV, 'a');
        if (!$fp) {
            throw new \Exception("Error al abrir el archivo CSV para escritura.");
        }
        // Escritura de la nueva vivienda en el archivo CSV
        fputcsv($fp, $vivienda->toArray());
        fclose($fp);
    }
    // Función para guardar en el csv
    public function toArray(): array {
        $extrasString = implode('-', $this->extras); // Convertir el array de extras a una cadena separada por -
        return [
            $this->tipo,
            $this->zona,
            $this->direccion,
            $this->dormitorios,
            $this->precio,
            $this->tamano,
            $extrasString, 
            $this->foto,
            $this->observaciones
        ];
    }
    
}
?>
