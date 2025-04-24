<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    session_start();
    require(__DIR__ . "/../../config/conexion.php");
    require(__DIR__ . "/../../config/depurar.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <?php include_once '../../../src/components/navbar.php'; ?>

    <div class="container mt-5 pt-5">

        <!-- Sección del filtro de busqueda -->
        <div class="row">
            <div class="col-12 bg-secondary text-white p-3">
                <h6>Filtrar</h6>
                <form action="#" method="post">
                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <input type="text" id="marca" name="marca">
                    </div>
                    <div class="form-group">
                        <label for="modelo">Modelo</label>
                        <input type="text" id="modelo" name="modelo">
                    </div>
                    <div class="form-group">
                        <label for="anno_matriculacion">Año matriculación</label>
                        <input type="range" id="anno_matriculacion" name="anno_matriculacion" min="1900" max="2099">
                        <span id="">Texto con el año que se vaya seleccionando (CON JAVASCRIPT)</span>
                    </div>
                    <div class="form-group">
                        <label for="kilometros">Kilómetros</label>
                        <input type="range" id="kilometros" name="kilometros" min="0" max="1000000">
                        <span id="">Texto con los km que se vaya seleccionando (CON JAVASCRIPT)</span>
                    </div>
                    <div class="form-group">
                        <label for="combustible">Combustible</label>
                        <select id="combustible" name="combustible">
                            <option selected hidden>Selecciona...</option>
                            <option value="gasolina">Gasolina</option>
                            <option value="diesel">Diésel</option>
                            <option value="hibrido">Híbrido</option>
                            <option value="electrico">Eléctrico</option>
                            <option value="glp">GLP</option>
                            <option value="gnc">GNC</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="transmision">Transmisión</label>
                        <select id="transmision" name="transmision">
                            <option selected hidden>Selecciona...</option>
                            <option value="manual">Manual</option>
                            <option value="automatica">Automática</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ubicacion">Ubicación</label>
                        <input type="text" id="ubicacion" name="ubicacion">
                    </div>
                    <div class="form-group">
                        <label for="tipo_aparcamiento">Tipo aparcamiento</label>
                        <select id="tipo_aparcamiento" name="tipo_aparcamiento">
                            <option selected hidden>Selecciona...</option>
                            <option value="calle">Calle</option>
                            <option value="garaje">Garaje</option>
                            <option value="parking">Parking</option>
                        </select>
                    </div>
                    <div class="form-group checkbox-group">
                        <label><input type="checkbox" name="accesibilidad"> Adaptado para personas con movilidad reducida</label>
                        <label><input type="checkbox" name="mascotas"> Admite mascotas</label>
                        <label><input type="checkbox" name="fumar"> Permite fumar</label>
                        <label><input type="checkbox" name="remolque"> Bola remolque</label>
                        <label><input type="checkbox" name="fumar"> Permite fumar</label>
                        <label><input type="checkbox" name="aire_acondicionado"> Aire acondicionado</label>
                        <label><input type="checkbox" name="gps"> GPS</label>
                        <label><input type="checkbox" name="wifi"> Wifi o Bluetooth</label>
                        <label><input type="checkbox" name="sensores_aparcamiento"> Sensores de aparcamiento</label>
                        <label><input type="checkbox" name="camara_reversa"> Cámara de reversa</label>
                        <label><input type="checkbox" name="control_crucero"> Control de crucero</label>
                        <label><input type="checkbox" name="asientos_calefactables"> Asientos calefactables</label>
                    </div>
                    <button id="eliminar">Eliminar Filtro</button>
                    <button type="submit">Filtrar</button>
                </form>
            </div>
        </div>

        <!-- Sección de todos los coches -->
        <div class="row">
            <div class="col-12 bg-primary text-white p-3 mt-auto">
                Mostrar los coches en cartas (cards)
            </div>
        </div>

    </div>

    <!-- Footer -->
    <?php include_once '../../../src/components/footer.php'; ?>


</body>

</html>