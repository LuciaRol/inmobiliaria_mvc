<?php
use Controllers\ViviendaController;

$controller = new ViviendaController();
$data = $controller->mostrarDatos();
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

    <?php if($_SERVER['REQUEST_METHOD'] =='POST'):?>

    <p><strong>Tipo de vivienda:</strong> <?= $data['tipo']; ?></p>
    <p><strong>Zona:</strong> <?= $data['zona']; ?></p>
    <p><strong>Dirección:</strong> <?= $data['direccion']; ?></p>
    <p><strong>Dormitorios:</strong> <?= $data['dormitorios']; ?></p>
    <p><strong>Precio:</strong> <?= $data['precio']; ?> €</p>
    <p><strong>Tamaño:</strong> <?= $data['tamano']; ?> m<sup>2</sup></p>
    <p><strong>Extras:</strong> 
        <?php foreach ($data['extras'] as $extra): ?>
            <?= $extra; ?>
        <?php endforeach; ?>
    </p>

    <?php if (isset($data['error'])): ?>
    <p><?= $data['error']; ?></p>
    <?php elseif (isset($data['imagePath'])): ?>
        <p> 
            <a href="<?= $data['imagePath']; ?>" target="_blank">Foto</a>
        </p>
    <?php else: ?>
        <p>No se subió ninguna foto.</p>
    <?php endif; ?>


    <p><strong>Observaciones:</strong> <?= $data['observaciones']; ?></p>
    <p><strong>Beneficio:</strong> <?= $data['beneficio'] * $data['precio']; ?>€</p>

    <?php endif;?>

    <a href="<?=BASE_URL?>index.php">Volver al formulario</a> 
</body>
</html>
