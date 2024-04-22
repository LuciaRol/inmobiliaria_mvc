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
    // Suponemos que el archivo fue enviado correctamente
    $tipo = $_POST['tipo'] ?? 'No especificado';
    $zona = $_POST['zona'] ?? 'No especificado';
    $direccion = $_POST['direccion'] ?? 'No especificado';
    $precio = $_POST['precio'] ?? 'No especificado';
    $tamano = $_POST['tamano'] ?? 'No especificado';
    $observaciones = $_POST['mensaje'] ?? 'No especificado';
    $archivo = $_FILES['archivo'] ?? null;

    echo "<p><strong>Tipo de vivienda:</strong> $tipo</p>";
    echo "<p><strong>Zona:</strong> $zona</p>";
    echo "<p><strong>Dirección:</strong> $direccion</p>";
    echo "<p><strong>Precio:</strong> $precio €</p>";
    echo "<p><strong>Tamaño:</strong> $tamano m<sup>2</sup></p>";
    echo "<p><strong>Observaciones:</strong> $observaciones</p>";

    if ($archivo && $archivo['error'] == UPLOAD_ERR_OK) {
        // Proceso de guardado del archivo
        $destino = 'uploads/' . $archivo['name'];
        if (move_uploaded_file($archivo['tmp_name'], $destino)) {
            echo "<p><strong>Foto:</strong> <img src='$destino' alt='Imagen de la vivienda' style='width: 300px;'></p>";
        } else {
            echo "<p>Error al guardar la foto.</p>";
        }
    } else {
        echo "<p>No se subió ninguna foto o hubo un error.</p>";
    }
    ?>
</body>
</html>
