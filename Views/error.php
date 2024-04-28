<?php

// Verifica si la variable $error está definida y no está vacía
$error = isset($error) && !empty($error) ? htmlentities($error) : "Se ha producido un error desconocido.";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de error</title>
</head>
<body>
    <h1>Error</h1>

    <p><?php echo $error; ?></p>

    <a href="<?=BASE_URL?>index.php">Volver al formulario</a> 
</body>
</html>