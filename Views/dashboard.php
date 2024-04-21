<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <div>
        <h1>INMOBILIARIA EXTRAORDINARIA</h1>
        <h2>- Plataforma del empleado -</h2>
    </div>
        
    <hr>

    <div>
        <h2>- Inserción de vivienda -</h2>
        <p>Introduzca los datos de la vivienda:</p>
    </div>

    <div class="form_container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="form_row">
            <label for="tipo">Tipo de vivienda:</label>
            <select id="tipo" name="tipo">
                <option value="Piso">Piso</option>
                <option value="Adosado">Adosado</option>
                <option value="Chalet">Chalet</option>
                <option value="Casa" selected>Casa</option>
            </select>
        </div>
        
        <div class="form_row">
            <label for="zona">Zona:</label>
            <select id="zona" name="zona">
                <option value="Centro" selected>Centro</option>
                <option value="Zaidín">Zaidín</option>
                <option value="La Chana">La Chana</option>
                <option value="Albaicín">Albaicín</option>
                <option value="Realejo">Realejo</option>
                <option value="Sacromonte">Sacromonte</option>
            </select>
        </div>

        <!-- Repite el patrón para los otros campos del formulario -->

        <div class="form_row">
            <label for="precio">Precio:</label>
            <input type="text" name="precio"> €
        </div>

        <div class="form_row">
            <label for="tamano">Tamaño:</label>
            <input type="text" name="tamano"> m<sup>2</sup>
        </div>

        <div class="form_row">
            <label for="archivo">Agregar foto:</label>
            <input type="file" id="archivo" name="archivo">
        </div>

        <div class="form_row">
            <label for="mensaje">Observaciones:</label>
            <textarea id="mensaje" name="mensaje" rows="4" cols="50"></textarea>
        </div>

        <div>
            <a href="<?=BASE_URL?>index.php?controller=Vivienda&action=mostrarVivienda"><input type="submit" value="Insertar vivienda"></a>
        </div>
    </form>
    </div>
</body>
</html>



