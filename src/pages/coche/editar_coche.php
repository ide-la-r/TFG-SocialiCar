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
        <h2>Editar coche</h2>
        <!-- Campo para matrícula -->
        <div class="form-group">
            <label for="matricula">Matrícula</label>
            <input type="text" id="matricula" name="matricula" required>
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
                <option value="" hidden>Selecciona...</option>
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
                <option value="" hidden>Selecciona...</option>
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
                <option value="" hidden>Selecciona...</option>
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

        <!--BOTON VENTANA MODAL CON BOOTSTRAP-->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">
            Abrir Modal
        </button>
        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="miModalLabel">Seleciona los extras</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group checkbox-group row">
                            <label class="col-6"><input type="checkbox" name="aire_acondicionado"> Aire acondicionado</label>
                            <label class="col-6"><input type="checkbox" name="gps"> GPS</label>
                            <label class="col-6"><input type="checkbox" name="wifi"> Wifi</label>
                            <label class="col-6"><input type="checkbox" name="sensores_aparcamiento"> Sensores de aparcamiento</label>
                            <label class="col-6"><input type="checkbox" name="camara_reversa"> Cámara de reversa</label>
                            <label class="col-6"><input type="checkbox" name="control_crucero"> Control de crucero</label>
                            <label class="col-6"><input type="checkbox" name="asientos_calefactables"> Asientos calefactables</label>
                            <label class="col-6"><input type="checkbox" name="mascota"> Mascota permitida</label>
                            <label class="col-6"><input type="checkbox" name="fumar"> Se permite fumar</label>
                            <label class="col-6"><input type="checkbox" name="accesibilidad"> Adaptado para personas con movilidad reducida</label>
                            <label class="col-6"><input type="checkbox" name="bola_remolque">Bola de remolque</label>
                            <label class="col-6"><input type="checkbox" name="aire_acondicionado">Aire acondicionado</label>
                            <label class="col-6"><input type="checkbox" name="fijaciones_isofix">Fijaciones isofix</label>
                            <label class="col-6"><input type="checkbox" name="android_carplay">Android carplay</label>
                            <label class="col-6"><input type="checkbox" name="apple_carplay">Apple carplay</label>
                            <label class="col-6"><input type="checkbox" name="baca">Baca</label>
                            <label class="col-6"><input type="checkbox" name="portabicicletas">Portabicicletas</label>
                            <label class="col-6"><input type="checkbox" name="portaequipajes">Portaequipajes</label>
                            <label class="col-6"><input type="checkbox" name="portaesquis">Portaesquis</label>
                            <label class="col-6"><input type="checkbox" name="seguro">Seguro</label>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Botón para enviar el formulario -->
        <button type="submit">Guardar coche</button>
    </form>
    <?php include_once '../../components/footer.php';?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.0/mdb.min.js"></script>
</body>

</html>

</html>