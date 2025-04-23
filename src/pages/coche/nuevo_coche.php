<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir coche</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>
<body>
<?php include_once '../../components/navbar.php'; ?>
    <form action="#" method="post">
        <h2>Añadir nuevo coche</h2>
        <!-- Campo para matrícula -->
        <div class="form-group">
            <label for="matricula">Matrícula</label>
            <input type="text" id="matricula" name="matricula" required>
        </div>
        <!-- Campo para seguro -->
        <div class="form-group">
            <label for="seguro">Seguro</label>
            <input type="text" id="seguro" name="seguro">
        </div>
        <!-- Campo para marca del coche -->
        <div class="form-group">
            <label for="marca">Marca</label>
            <input type="text" id="marca" name="marca" required>
        </div>
        <!-- Campo para modelo del coche -->
        <div class="form-group">
            <label for="modelo">Modelo</label>
            <input type="text" id="modelo" name="modelo" required>
        </div>
        <!-- Campo para año de matriculación -->
        <div class="form-group">
            <label for="anno_matriculacion">Año matriculación</label>
            <input type="number" id="anno_matriculacion" name="anno_matriculacion" min="1900" max="2099">
        </div>
        <!-- Campo para kilómetros del coche -->
        <div class="form-group">
            <label for="kilometros">Kilómetros</label>
            <input type="number" id="kilometros" name="kilometros" min="0">
        </div>
        <!-- Selector para tipo de combustible -->
        <div class="form-group">
            <label for="combustible">Combustible</label>
            <select id="combustible" name="combustible">
                <option value="">Selecciona...</option>
                <option value="gasolina">Gasolina</option>
                <option value="diesel">Diésel</option>
                <option value="hibrido">Híbrido</option>
                <option value="electrico">Eléctrico</option>
                <option value="glp">GLP</option>
                <option value="gnc">GNC</option>
            </select>
        </div>
        <!-- Selector para tipo de transmisión -->
        <div class="form-group">
            <label for="transmision">Transmisión</label>
            <select id="transmision" name="transmision">
                <option value="">Selecciona...</option>
                <option value="manual">Manual</option>
                <option value="automatica">Automática</option>
            </select>
        </div>
        <!-- Campo para ubicación del coche -->
        <div class="form-group">
            <label for="ubicacion">Ubicación</label>
            <input type="text" id="ubicacion" name="ubicacion">
        </div>
        <!-- Selector para tipo de aparcamiento -->
        <div class="form-group">
            <label for="tipo_aparcamiento">Tipo aparcamiento</label>
            <select id="tipo_aparcamiento" name="tipo_aparcamiento">
                <option value="">Selecciona...</option>
                <option value="calle">Calle</option>
                <option value="garaje">Garaje</option>
                <option value="parking">Parking</option>
            </select>
        </div>
        
        <!-- Campo para la ruta de la imagen del coche -->
        <div class="form-group">
            <label for="ruta_img_coche">Ruta img. coche</label>
            <input type="file" id="ruta_img_coche" name="ruta_img_coche">
        </div>
        <!-- Selector para indicar si es apto para movilidad reducida -->
        <div class="form-group">
            <label for="movilidad_reducida">Movilidad reducida</label>
            <select id="movilidad_reducida" name="movilidad_reducida">
                <option value="">Selecciona...</option>
                <option value="si">Sí</option>
                <option value="no">No</option>
            </select>
        </div>
        <!-- Checbox de los extras de coche -->
        <div class="form-group checkbox-group">
    <label><input type="checkbox" name="aire_acondicionado"> Aire acondicionado</label>
    <label><input type="checkbox" name="gps"> GPS</label>
    <label><input type="checkbox" name="wifi"> Wifi</label>
    <label><input type="checkbox" name="sensores_aparcamiento"> Sensores de aparcamiento</label>
    <label><input type="checkbox" name="camara_reversa"> Cámara de reversa</label>
    <label><input type="checkbox" name="control_crucero"> Control de crucero</label>
    <label><input type="checkbox" name="asientos_calefactables"> Asientos calefactables</label>
    <label><input type="checkbox" id="mascota" name="mascota" value="si"> Mascota permitida</label>
    <label><input type="checkbox" id="fumar" name="fumar" value="si"> Se permite fumar</label>
</div>
        <!-- Botón para enviar el formulario -->
        <button type="submit">Guardar coche</button>
    </form>
    <?php include_once '../../components/footer.php'; ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.js"></script>
</body>
</html>
</html>