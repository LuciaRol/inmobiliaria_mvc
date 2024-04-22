<?php
use Controllers\ViviendaController; 

$controller = new ViviendaController();
$data = $controller->mostrarViviendaData();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de la Nueva Vivienda</title>
</head>
<body>
    <h1>Información de la nueva vivienda</h1>
    
    <?php
    // Mostrar la información obtenida del controlador
    echo "<p><strong>Tipo de vivienda:</strong> " . $data['tipo'] . "</p>";
    echo "<p><strong>Zona:</strong> " . $data['zona'] . "</p>";
    echo "<p><strong>Dirección:</strong> " . $data['direccion'] . "</p>";
    echo "<p><strong>Dormitorios:</strong> " . $data['dormitorios'] . "</p>";
    echo "<p><strong>Precio:</strong> " . $data['precio'] . " €</p>";
    echo "<p><strong>Tamaño:</strong> " . $data['tamano'] . " m<sup>2</sup></p>";
    echo "<p><strong>Observaciones:</strong> " . $data['observaciones'] . "</p>";

    if (isset($data['imagePath'])) {
        echo "<p><strong>Foto:</strong> <img src='" . $data['imagePath'] . "' alt='Imagen de la vivienda' style='width: 300px;'></p>";
    } else {
        echo "<p>No se subió ninguna foto o su tamaño excede los 100kb.</p>";
    }
    echo "<p><strong>Beneficio:</strong> " . $data['beneficio'] * $data['precio'] . "€" . "</p>";
    ?>
</body>
</html>
