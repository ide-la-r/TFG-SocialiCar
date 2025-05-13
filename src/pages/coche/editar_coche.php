<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="../../styles/nuevo_coche.css">
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    session_start();
    require(__DIR__ . "/../../config/conexion.php");
    require(__DIR__ . "/../../config/depurar.php");

    // Redirigir si no hay sesión iniciada
    if (!isset($_SESSION['usuario'])) {
        header("Location: ../../../");
        exit();
    }
    ?>

    <style>
        .error {
            color: #e03131;
            font-size: 1em;
        }
    </style>
</head>

<body>
    <?php include_once '../../components/navbar.php'; ?>

    <?php

    if (isset($_GET['matricula'])) {
        $matricula_obtenida = $_GET["matricula"];

        $consulta_coche = $_conexion->prepare("SELECT * FROM coche WHERE matricula = ?");
        $consulta_coche->bind_param("s", $matricula_obtenida);
        $consulta_coche->execute();
        $datos_coche = $consulta_coche->get_result();

        while ($fila = $datos_coche->fetch_assoc()) {
            $marca = $fila["marca"];
            $modelo = $fila["modelo"];
            $anno_matriculacion = substr($fila["anno_matriculacion"], 0, 7);
            $kilometros = $fila["kilometros"];
            $combustible = $fila["combustible"];
            $transmision = $fila["transmision"];
            $provincia = $fila["provincia"];
            $ciudad = $fila["ciudad"];
            $codigo_postal = $fila["codigo_postal"];
            $direccion = $fila["direccion"];
            $tipo_aparcamiento = $fila["tipo_aparcamiento"];
            $tipo = $fila["tipo"];
            $precio = $fila["precio"];
            $descripcion = $fila["descripcion"];
            $color = $fila["color"];
            $plazas = $fila["plazas"];
            $puertas = $fila["puertas"];
            $potencia = $fila["potencia"];
        }
    }


    ?>



    <form action="#" method="post" enctype="multipart/form-data">
        <!-- INFORMACION DEL VEHICULO (MARCA MODELO Y ANNO DE MATRICULACION) -->
        <div class="container mt-5 pt-5">
            <div class="card py-4 px-2 px-md-4">
                <h3 class="text-start mb-4">Información básica</h3>
                <div class="row gy-3 justify-content-center">

                    <?php
                    // API para obtener las marcas de coches
                    $apiUrlMarcas = "https://vpic.nhtsa.dot.gov/api/vehicles/GetMakesForVehicleType/car?format=json";

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $apiUrlMarcas);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $respuesta = curl_exec($curl);
                    curl_close($curl);

                    $datos = json_decode($respuesta, true);
                    $marcas = $datos['Results'];

                    $marcaSeleccionada = isset($_POST['marca']) ? $_POST['marca'] : '';
                    $modeloSeleccionado = isset($_POST['modelo']) ? $_POST['modelo'] : '';
                    ?>

                    <!-- Marca -->
                    <div class="col-12 col-md-3">
                        <div class="form-floating">
                            <select class="form-select <?php if (isset($err_marca)) echo 'is-invalid'; ?>" id="marca" name="marca">
                                <option disabled selected hidden><?php if (!isset($marca_nuevo)) echo $marca; ?></option>
                                <?php foreach ($marcas as $marcaItem) { ?>
                                    <option value="<?php echo $marcaItem["MakeName"]; ?>"
                                        <?php if ($marcaSeleccionada === $marcaItem["MakeName"]) echo "selected"; ?>>
                                        <?php echo $marcaItem["MakeName"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <label for="marca">Marca</label>
                            <?php
                            if (isset($err_marca)) {
                                echo "<span class='error'>$err_marca</span>";
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Modelo -->
                    <div class="col-12 col-md-3">
                        <div class="form-floating">
                            <select class="form-select <?php if (isset($err_modelo)) echo 'is-invalid'; ?>" id="modelo" name="modelo" data-selected="<?php echo htmlspecialchars($modeloSeleccionado); ?>">
                                <option disabled selected hidden><?php if (!isset($modelo_nuevo)) echo $modelo; ?></option>
                            </select>
                            <label for="modelo">Modelo</label>
                            <?php
                            if (isset($err_modelo)) {
                                echo "<span class='error'>$err_modelo</span>";
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Año de matriculación -->
                    <div class="col-12 col-md-3">
                        <div class="form-floating">
                            <input class="form-control <?php if (isset($err_anno_matriculacion)) echo 'is-invalid'; ?>" placeholder="Año de matriculacion" id="inputMes" type="month" name="anno_matriculacion" value="<?php echo $anno_matriculacion;
                                                                                                                                                                                                                        if (isset($_POST['anno_matriculacion'])) echo htmlspecialchars($_POST['anno_matriculacion']); ?>">
                            <label for="inputMes">Año de matriculación</label>
                            <?php
                            if (isset($err_anno_matriculacion)) {
                                echo "<span class='error'>$err_anno_matriculacion</span>";
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Matrícula -->
                    <div class="col-12 col-md-3">
                        <div class="form-floating">
                            <div class="form-control"
                                style="pointer-events: none; user-select: none; cursor: not-allowed; background-color: #e9ecef;">
                                <?php echo htmlspecialchars($matricula_obtenida); ?>
                            </div>
                            <label for="floatingInput">Matrícula</label>
                            <?php
                            if (isset($err_matricula)) {
                                echo "<span class='error'>$err_matricula</span>";
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>





        <div class="container mt-5 pt-5">

            <div class="container card">
                <br>
                <h3>Información del vehículo</h3>
                <div class="row justify-content-center pt-3">
                    <div class="mb-3 col-6">
                        <div class="form-floating">
                            <input class="form-control <?php if (isset($err_kilometros)) echo 'is-invalid'; ?>" id="kilometros" type="number" placeholder="Kilómetros*" name="kilometros" value="<?php if (!isset($kilometros_nuevo)) echo "$kilometros" ?>">
                            <label for="kilometros">Kilómetros</label>
                            <?php
                            if (isset($err_kilometros)) {
                                echo "<span class='error'>$err_kilometros</span>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="mb-3 col-6">
                        <div class="form-floating">
                            <select class="form-select <?php if (isset($err_tipo_combustible)) echo 'is-invalid'; ?>" id="tipo_combustible" name="tipo_combustible">
                                <option disabled selected hidden>Tipo de combustible*</option>
                                <option value="gasolina"
                                    <?php if (isset($_POST['tipo_combustible']) && $_POST['tipo_combustible'] == "gasolina") echo "selected"; ?>>
                                    Gasolina
                                </option>
                                <option value="diesel"
                                    <?php if (isset($_POST['tipo_combustible']) && $_POST['tipo_combustible'] == "diesel") echo "selected"; ?>>
                                    Diesel
                                </option>
                                <option value="hibrido"
                                    <?php if (isset($_POST['tipo_combustible']) && $_POST['tipo_combustible'] == "hibrido") echo "selected"; ?>>
                                    Híbrido
                                </option>
                                <option value="electrico"
                                    <?php if (isset($_POST['tipo_combustible']) && $_POST['tipo_combustible'] == "electrico") echo "selected"; ?>>
                                    Eléctrico
                                </option>
                                <option value="glp"
                                    <?php if (isset($_POST['tipo_combustible']) && $_POST['tipo_combustible'] == "glp") echo "selected"; ?>>
                                    GLP
                                </option>
                                <option value="gnc"
                                    <?php if (isset($_POST['tipo_combustible']) && $_POST['tipo_combustible'] == "gnc") echo "selected"; ?>>
                                    GNC
                                </option>
                            </select>
                            <label for="tipo_combustible">Tipo de combustible</label>
                            <?php
                            if (isset($err_tipo_combustible)) {
                                echo "<span class='error'>$err_tipo_combustible</span>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="mb-3 col-6">
                        <div class="form-floating">
                            <select class="form-select <?php if (isset($err_tipo)) echo 'is-invalid'; ?>" id="tipo" name="tipo">
                                <option disabled selected hidden>Tipo de coche*</option>
                                <option value="berlina" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "berlina") echo "selected"; ?>>
                                    Berlina
                                </option>
                                <option value="coupe" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "coupe") echo "selected"; ?>>
                                    Coupé
                                </option>
                                <option value="deportivo" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "deportivo") echo "selected"; ?>>
                                    Deportivo
                                </option>
                                <option value="furgoneta" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "furgoneta") echo "selected"; ?>>
                                    Furgoneta
                                </option>
                                <option value="monovolumen" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "monovolumen") echo "selected"; ?>>
                                    Monovolumen
                                </option>
                                <option value="suv" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "suv") echo "selected"; ?>>
                                    SUV
                                </option>
                                <option value="pick-up" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "pick-up") echo "selected"; ?>>
                                    Pick-up
                                </option>
                                <option value="roadster" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "roadster") echo "selected"; ?>>
                                    Roadster
                                </option>
                                <option value="utilitario" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "utilitario") echo "selected"; ?>>
                                    Utilitario
                                </option>
                                <option value="familiar" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "familiar") echo "selected"; ?>>
                                    Familiar
                                </option>
                                <option value="autocaravana" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "autocaravana") echo "selected"; ?>>
                                    Autocaravana
                                </option>
                            </select>
                            <label for="tipo">Tipo de coche</label>

                            <?php
                            if (isset($err_tipo)) {
                                echo "<span class='error'>$err_tipo</span>";
                            }
                            ?>
                        </div>
                    </div>


                    <div class="mb-3 col-6">
                        <div class="form-floating">
                            <select class="form-select <?php if (isset($err_transmision)) echo 'is-invalid'; ?>" id="transmision" name="transmision">
                                <option disabled selected hidden>Transmisión*</option>
                                <option value="manual" <?php if (isset($_POST['transmision']) && $_POST['transmision'] == "manual") echo "selected"; ?>>
                                    Manual
                                </option>
                                <option value="automatico" <?php if (isset($_POST['transmision']) && $_POST['transmision'] == "automatico") echo "selected"; ?>>
                                    Automática
                                </option>
                            </select>
                            <label for="transmision">Transmisión</label>
                            <?php
                            if (isset($err_transmision)) {
                                echo "<span class='error'>$err_transmision</span>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="mb-3 col-6">
                        <div class="form-floating">
                            <select class="form-select <?php if (isset($err_color)) echo 'is-invalid'; ?>" id="color" name="color" required>
                                <option disabled selected hidden>Color*</option>
                                <option value="white">Blanco</option>
                                <option value="black">Negro</option>
                                <option value="gray">Gris</option>
                                <option value="red">Rojo</option>
                                <option value="blue">Azul</option>
                                <option value="green">Verde</option>
                                <option value="yellow">Amarillo</option>
                                <option value="orange">Naranja</option>
                                <option value="brown">Marrón</option>
                                <option value="others">Otros</option>
                            </select>
                            <label for="color">Color</label>

                            <?php
                            if (isset($err_color)) {
                                echo "<span class='error'>$err_color</span>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="mb-3 col-6">
                        <div class="form-floating">
                            <input class="form-control <?php if (isset($err_potencia)) echo 'is-invalid'; ?>" min="30" max="2000" id="potencia" type="number" placeholder="Potencia*" name="potencia" value="<?php if (isset($potencia)) echo "$potencia" ?>">
                            <label for="potencia">Potencia</label>
                            <?php
                            if (isset($err_potencia)) {
                                echo "<span class='error'>$err_potencia</span>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="mb-3 col-6">
                        <div class="form-floating">
                            <input class="form-control <?php if (isset($err_numero_puertas)) echo 'is-invalid'; ?>" min="2" max="5" id="numero_puertas" type="number" placeholder="Numero de puertas*" name="numero_puertas" value="<?php if (isset($puertas)) echo "$puertas" ?>">
                            <label for="numero_puertas">Numero de puertas</label>
                            <?php
                            if (isset($err_numero_puertas)) {
                                echo "<span class='error'>$err_numero_puertas</span>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="mb-3 col-6">
                        <div class="form-floating">
                            <input class="form-control <?php if (isset($err_numero_plazas)) echo 'is-invalid'; ?>" min="1" max="9" id="numero_plazas" type="number" placeholder="Numero de plazas*" name="numero_plazas" value="<?php if (isset($plazas)) echo "$plazas" ?>">
                            <label for="numero_plazas">Numero de plazas</label>
                            <?php
                            if (isset($err_numero_plazas)) {
                                echo "<span class='error'>$err_numero_plazas</span>";
                            }
                            ?>
                        </div>
                    </div>

                    <div>
                        <div class="form-floating">
                            <textarea class="form-control <?php if (isset($err_descripcion)) echo 'is-invalid'; ?>" name="descripcion" id="floatingTextarea2" rows="3" style="height: 100px" placeholder="Descripcion*"><?php if (isset($descripcion)) echo "$descripcion"; ?></textarea>
                            <label for="floatingTextarea2">Descripcion</label>
                            <?php
                            if (isset($err_descripcion)) {
                                echo "<span class='error'>$err_descripcion</span>";
                            }
                            ?>
                            <br>
                        </div>
                    </div>


                </div>
            </div>
        </div>


        <div class="container mt-5 pt-5">
            <div class="container card py-4">
                <h3 class="text-start">Precio</h3>

                <div class="d-flex flex-column align-items-center">
                    <label id="totalPrecio" class="form-label fw-bold">Precio Diario: <span id="mostrarPrecio">15€</span></label>

                    <input type="range" class="form-range w-75" name="precio" id="precio" min="15" max="500" step="1" value="15">

                    <div class="d-flex justify-content-between text-muted mt-1 w-75">
                        <span>15€</span>
                        <span>500€</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plantillas para los inputs flotantes -->
        <!--         <div class="form-floating">
            <label for="floatingInput"></label>
        </div> -->
        <!-- Plantillas para los inputs flotantes -->

        <div class="container mt-5 pt-5">
            <div class="container card py-4">
                <h3 class="text-start">Ubicación</h3>
                <div class="row justify-content-center pt-3">
                    <div class="mb-3 col-6">
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput" type="text" placeholder="Direccion*" name="direccion" value="">
                            <label for="floatingInput">Dirección</label>
                        </div>


                    </div>
                    <div class="mb-3 col-6">
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput" type="number" placeholder="Código Postal*" name="cp" value="">
                            <label for="floatingInput">Código Postal</label>
                        </div>


                    </div>
                    <div class="mb-3 col-6">
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput" type="text" placeholder="Provincia*" name="provincia" value="">
                            <label for="floatingInput">Provincia</label>
                        </div>

                    </div>
                    <div class="mb-3 col-6">
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput" type="text" placeholder="Ciudad*" name="ciudad" value="">
                            <label for="floatingInput">Ciudad</label>
                        </div>

                    </div>
                    <div class="mb-3 col-6">
                        <div class="form-floating">
                            <Select class="form-select" id="floatingSelect" name="tipo_aparcamiento">
                                <option disabled selected hidden>Tipo de aparcamiento*</option>
                                <option value="calle">
                                    Calle
                                </option>
                                <option value="garaje">
                                    Garaje
                                </option>
                                <option value="parking">
                                    Parking
                                </option>
                            </Select>
                            <label for="floatingInput">Tipo de aparcamiento</label>
                        </div>

                    </div>
                </div>


            </div>
        </div>

        <div class="container mt-5 pt-5">
            <div class="container card py-4">
                <h3>Imágenes</h3>
                <div class="row justify-content-center pt-3">
                    <div class="col">
                        <input class="form-control" id="img" type="file" name="img[]" multiple accept="image/png, image/jpg, image/jpeg">
                    </div>
                </div>
            </div>
        </div>


        <!--         <div class="container mt-5 pt-5">
            <div class="container card py-4">
                <h3 class="text-start">SEGURO</h3>
                <div class="row justify-content-center pt-3">
                    <div class="mb-3 col-6">
                        <div class=" mb-3 col-6 form-switch">
                            <input type="checkbox" class="custom-switch" role="switch" id="flexSwitchCheckChecked" name="seguro" checked <?php if (isset($_POST['seguro'])) echo 'checked'; ?>>
                            <label class="" for="flexSwitchCheckChecked">
                                Dispone de seguro actualmente?
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->


        <div class="container mt-5 pt-5">
            <div class="card py-4">

                <div class="row justify-content-center pt-3">
                    <div class="col-auto">
                        <button type="button" class="boton-redondo" data-bs-toggle="modal" data-bs-target="#miModal">
                            Extras
                        </button>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="boton-redondo">
                            Confirmar
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <br>
        </div>
        </div>
        <!-- VENTANA MODAL CON BOOTSTRAP -->
        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="miModalLabel">Selecciona los extras</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Sección Características Básicas -->
                        <div>
                            <div>
                                <h6>Características Básicas</h6>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="mascota">
                                    <label>
                                        Permito mascotas
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="fumar">
                                    <label>
                                        Permito fumar
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Asistencia a la Conducción -->
                        <div>
                            <div>
                                <h6>Asistencia a la Conducción</h6>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="gps">
                                    <label>
                                        GPS
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="sensores_aparcamiento">
                                    <label>
                                        Sensores de aparcamiento
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="camara_trasera">
                                    <label>
                                        Cámara de reversa
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="control_de_crucero">
                                    <label>
                                        Control de crucero
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="cuatro_x_cuatro">
                                    <label>
                                        Tracción 4x4
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Portaequipajes y Accesorios -->
                        <div>
                            <div>
                                <h6>Portaequipajes y Accesorios</h6>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="baca">
                                    <label>
                                        Baca
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="portabicicletas">
                                    <label>
                                        Portabicicletas
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="portaequipajes">
                                    <label>
                                        Portaequipajes
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="portaesquis">
                                    <label>
                                        Portaesquís
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="bola_remolque">
                                    <label>
                                        Bola de remolque
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Tecnología y Navegación -->
                        <div>
                            <div>
                                <h6>Tecnología y Navegación</h6>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="bluetooth">
                                    <label>
                                        Bluetooth
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="wifi">
                                    <label>
                                        WiFi
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="android_carplay">
                                    <label>
                                        Android CarPlay
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="apple_carplay">
                                    <label>
                                        Apple CarPlay
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Confort y Equipamiento -->
                        <div>
                            <div>
                                <h6>Confort y Equipamiento</h6>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="aire_acondicionado">
                                    <label>
                                        Aire acondicionado
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="asientos_calefactables">
                                    <label>
                                        Asientos calefactables
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="fijacion_isofix">
                                    <label>
                                        Fijaciones ISOFIX
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" name="movilidad_reducia">
                                    <label>
                                        Adaptado para personas con movilidad reducida
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- BOTÓN CERRAR DE LA VENTANA MODAL -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
    <?php include_once '../../components/footer.php'; ?>
    <script src="../../js/mostrar_marcas.js"></script>
    <script src="../../js/nuevo_coche.js"></script>
    <script src="../../js/pre_imagen.js"></script>
</body>

</html>