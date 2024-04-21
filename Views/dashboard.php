<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div>
                <label for="tipo">Tipo de vivienda: </label>
                <select id="tipo" name="tipo">
                    <option value="Piso">Piso</option>
                    <option value="Adosado">Adosado</option>
                    <option value="Chalet">Chalet</option>
                    <option value="Casa" selected>Casa</option>
                </select>
            </div>
            
            <div>
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

            <div>
                <label for="dormitorios">Número de dormitorios: </label>

                <input type="radio" id="dormitorios1" name="dormitorios" value="1">
                <label for="dormitorios1">1</label>

                <input type="radio" id="dormitorios2" name="dormitorios" value="2">
                <label for="dormitorios2">2</label>

                <input type="radio" id="dormitorios3" name="dormitorios" value="3">
                <label for="dormitorios3">3</label>

                <input type="radio" id="dormitorios4" name="dormitorios" value="4">
                <label for="dormitorios4">4</label>

                <input type="radio" id="dormitorios5" name="dormitorios" value="5">
                <label for="dormitorios5">5</label>
            </div>

            <div>
                <label for="precio">Precio:</label>
                <input type="text" name="precio"> €
            </div>

            <div>
                <label for="tamano">Tamaño:</label>
                <input type="text" name="tamano"> m<sup>2</sup>
            </div>

            <div>
                <label for="extra">Extras (marque los que procedan): </label>

                <input type="checkbox" id="extra1" name="extra[]" value="Piscina">
                <label for="extra1">Piscina</label>
                
                <input type="checkbox" id="extra2" name="extra[]" value="Jardín">
                <label for="extra2">Jardín</label>
                
                <input type="checkbox" id="extra3" name="extra[]" value="Garaje">
                <label for="extra3">Garaje</label>
            </div>

            <div>
                <label for="archivo">Agregar foto:</label>
                <input type="file" id="archivo" name="archivo">
            </div>

            <div>
                <label for="mensaje">Observaciones: </label>
                <textarea id="mensaje" name="mensaje" rows="4" cols="50"></textarea>
            </div>

            <div>
                <input type="submit" value="Insertar vivienda">
            </div>
        </form>
    </div>
</body>
</html>
