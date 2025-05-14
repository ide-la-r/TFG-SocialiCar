<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="../../styles/nuevo_coche_custom.css">
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
            $id_usuario = $fila["id_usuario"];
            $seguro = $fila["seguro"];
            $marca = $fila["marca"];
            $modelo = $fila["modelo"];
            $anno_matriculacion = substr($fila["anno_matriculacion"], 0, 7);
            $kilometros = $fila["kilometros"];
            $combustible = $fila["combustible"];
            $transmision = $fila["transmision"];
            $direccion = $fila["direccion"];
            $ciudad = $fila["ciudad"];
            $provincia = $fila["provincia"];
            $codigo_postal = $fila["codigo_postal"];
            $pais = $fila["pais"];
            $lat = $fila["lat"];
            $lon = $fila["lon"];
            $tipo_aparcamiento = $fila["tipo_aparcamiento"];
            $ruta_img_coche = $fila["ruta_img_coche"];
            $tipo = $fila["tipo"];
            $precio = $fila["precio"];
            $descripcion = $fila["descripcion"];
            $color = $fila["color"];
            $colores = [
                "white" => "Blanco",
                "black" => "Negro",
                "gray" => "Gris",
                "red" => "Rojo",
                "blue" => "Azul",
                "green" => "Verde",
                "yellow" => "Amarillo",
                "orange" => "Naranja",
                "brown" => "Marrón",
                "other" => "Otros"
            ];
            $color_esp = $colores[$color] ?? "Otros";
            $plazas = $fila["plazas"];
            $puertas = $fila["puertas"];
            $potencia = $fila["potencia"];
        }


        $consulta_extras_coche = $_conexion->prepare("SELECT * FROM extras_coche WHERE matricula = ?");
        $consulta_extras_coche->bind_param("s", $matricula_obtenida);
        $consulta_extras_coche->execute();
        $datos_extra_coche = $consulta_extras_coche->get_result();

        while ($fila = $datos_extra_coche->fetch_assoc()) {
            $aire_acondicionado = $fila["aire_acondicionado"];
            $gps = $fila["gps"];
            $wifi = $fila["wifi"];
            $sensores_aparcamiento = $fila["sensores_aparcamiento"];
            $camara_trasera = $fila["camara_trasera"];
            $control_de_crucero = $fila["control_de_crucero"];
            $asientos_calefactables = $fila["asientos_calefactables"];
            $bola_remolque = $fila["bola_remolque"];
            $fijacion_isofix = $fila["fijacion_isofix"];
            $apple_carplay = $fila["apple_carplay"];
            $android_carplay = $fila["android_carplay"];
            $baca = $fila["baca"];
            $portabicicletas = $fila["portabicicletas"];
            $portaequipajes = $fila["portaequipajes"];
            $portaesquis = $fila["portaesquis"];
            $bluetooth = $fila["bluetooth"];
            $cuatro_x_cuatro = $fila["cuatro_x_cuatro"];
            $mascota = $fila["mascota"];
            $fumar = $fila["fumar"];
            $movilidad_reducida = $fila["movilidad_reducida"];
        }
    }





    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        /* Coche */
        if (isset($_POST['seguro']) && $_POST['seguro'] != $seguro) {
            $seguro_nuevo = $_POST['seguro'];
        }
        if (isset($_POST['marca']) && $_POST['marca'] != $marca) {
            $marca_nuevo = $_POST['marca'];
        }
        if (isset($_POST['modelo']) && $_POST['modelo'] != $modelo) {
            $modelo_nuevo = $_POST['modelo'];
        }
        if (isset($_POST['anno_matriculacion']) && $_POST['anno_matriculacion'] != $anno_matriculacion) {
            $anno_matriculacion_nuevo = $_POST['anno_matriculacion'];
            echo $anno_matriculacion;
        }
        if (isset($_POST['kilometros']) && $_POST['kilometros'] != $kilometros) {
            $kilometros_nuevo = $_POST['kilometros'];
        }
        if (isset($_POST['tipo_combustible']) && $_POST['tipo_combustible'] != $combustible) {
            $combustible_nuevo = $_POST['tipo_combustible'];
        }
        if (isset($_POST['transmision']) && $_POST['transmision'] != $transmision) {
            $transmision_nuevo = $_POST['transmision'];
        }
        if (isset($_POST['direccion']) && $_POST['direccion'] != $direccion) {
            $direccion_nuevo = $_POST['direccion'];
        }
        if (isset($_POST['ciudad']) && $_POST['ciudad'] != $ciudad) {
            $ciudad_nueva = $_POST['ciudad'];
        }
        if (isset($_POST['provincia']) && $_POST['provincia'] != $provincia) {
            $provincia_nueva = $_POST['provincia'];
        }
        if (isset($_POST['codigo_postal']) && $_POST['codigo_postal'] != $codigo_postal) {
            $codigo_postal_nuevo = $_POST['codigo_postal'];
        }
        if (isset($_POST['pais']) && $_POST['pais'] != $pais) {
            $pais_nuevo = $_POST['pais'];
        }
        if (isset($_POST['lat']) && $_POST['lat'] != $lat) {
            $lat_nueva = $_POST['lat'];
        }
        if (isset($_POST['lon']) && $_POST['lon'] != $lon) {
            $lon_nueva = $_POST['lon'];
        }
        if (isset($_POST['tipo_aparcamiento']) && $_POST['tipo_aparcamiento'] != $tipo_aparcamiento) {
            $tipo_aparcamiento_nuevo = $_POST['tipo_aparcamiento'];
        }
        if (isset($_POST['tipo']) && $_POST['tipo'] != $tipo) {
            $tipo_nuevo = $_POST['tipo'];
        }
        if (isset($_POST['precio']) && $_POST['precio'] != $precio) {
            $precio_nuevo = $_POST['precio'];
        }
        if (isset($_POST['descripcion']) && $_POST['descripcion'] != $descripcion) {
            $descripcion_nuevo = $_POST['descripcion'];
        }
        if (isset($_POST['color']) && $_POST['color'] != $color) {
            $color_nuevo = $_POST['color'];
        }
        if (isset($_POST['numero_plazas']) && $_POST['numero_plazas'] != $plazas) {
            $plazas_nuevo = $_POST['numero_plazas'];
        }
        if (isset($_POST['numero_puertas']) && $_POST['numero_puertas'] != $puertas) {
            $puertas_nuevo = $_POST['numero_puertas'];
        }
        if (isset($_POST['potencia']) && $_POST['potencia'] != $potencia) {
            $potencia_nuevo = $_POST['potencia'];
        }


        /* Extras */
        if (isset($_POST['aire_acondicionado']) && $_POST['aire_acondicionado'] != $aire_acondicionado) {
            $aire_acondicionado_nuevo = $_POST['aire_acondicionado'];
        }
        if (isset($_POST['gps']) && $_POST['gps'] != $gps) {
            $gps_nuevo = $_POST['gps'];
        }
        if (isset($_POST['wifi']) && $_POST['wifi'] != $wifi) {
            $wifi_nuevo = $_POST['wifi'];
        }
        if (isset($_POST['sensores_aparcamiento']) && $_POST['sensores_aparcamiento'] != $sensores_aparcamiento) {
            $sensores_aparcamiento_nuevo = $_POST['sensores_aparcamiento'];
        }
        if (isset($_POST['camara_trasera']) && $_POST['camara_trasera'] != $camara_trasera) {
            $camara_trasera_nuevo = $_POST['camara_trasera'];
        }
        if (isset($_POST['control_de_crucero']) && $_POST['control_de_crucero'] != $control_de_crucero) {
            $control_de_crucero_nuevo = $_POST['control_de_crucero'];
        }
        if (isset($_POST['asientos_calefactables']) && $_POST['asientos_calefactables'] != $asientos_calefactables) {
            $asientos_calefactables_nuevo = $_POST['asientos_calefactables'];
        }
        if (isset($_POST['bola_remolque']) && $_POST['bola_remolque'] != $bola_remolque) {
            $bola_remolque_nuevo = $_POST['bola_remolque'];
        }
        if (isset($_POST['fijacion_isofix']) && $_POST['fijacion_isofix'] != $fijacion_isofix) {
            $fijacion_isofix_nuevo = $_POST['fijacion_isofix'];
        }
        if (isset($_POST['apple_carplay']) && $_POST['apple_carplay'] != $apple_carplay) {
            $apple_carplay_nuevo = $_POST['apple_carplay'];
        }
        if (isset($_POST['android_carplay']) && $_POST['android_carplay'] != $android_carplay) {
            $android_carplay_nuevo = $_POST['android_carplay'];
        }
        if (isset($_POST['baca']) && $_POST['baca'] != $baca) {
            $baca_nuevo = $_POST['baca'];
        }
        if (isset($_POST['portabicicletas']) && $_POST['portabicicletas'] != $portabicicletas) {
            $portabicicletas_nuevo = $_POST['portabicicletas'];
        }
        if (isset($_POST['portaequipajes']) && $_POST['portaequipajes'] != $portaequipajes) {
            $portaequipajes_nuevo = $_POST['portaequipajes'];
        }
        if (isset($_POST['portaesquis']) && $_POST['portaesquis'] != $portaesquis) {
            $portaesquis_nuevo = $_POST['portaesquis'];
        }
        if (isset($_POST['bluetooth']) && $_POST['bluetooth'] != $bluetooth) {
            $bluetooth_nuevo = $_POST['bluetooth'];
        }
        if (isset($_POST['cuatro_x_cuatro']) && $_POST['cuatro_x_cuatro'] != $cuatro_x_cuatro) {
            $cuatro_x_cuatro_nuevo = $_POST['cuatro_x_cuatro'];
        }
        if (isset($_POST['mascota']) && $_POST['mascota'] != $mascota) {
            $mascota_nuevo = $_POST['mascota'];
        }
        if (isset($_POST['fumar']) && $_POST['fumar'] != $fumar) {
            $fumar_nuevo = $_POST['fumar'];
        }
        if (isset($_POST['movilidad_reducida']) && $_POST['movilidad_reducida'] != $movilidad_reducida) {
            $movilidad_reducida_nuevo = $_POST['movilidad_reducida'];
        }
    }
    ?>


    <div class="container">
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
                                <option disabled selected hidden><?php if (!isset($marca_nuevo)) echo $marca;
                                                                    else echo $marca_nuevo; ?></option>
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
                                <option disabled selected hidden><?php if (!isset($modelo_nuevo)) echo $modelo;
                                                                    else echo $modelo_nuevo; ?></option>
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
                            <input class="form-control <?php if (isset($err_anno_matriculacion)) echo 'is-invalid'; ?>" placeholder="Año de matriculacion" id="inputMes" type="month" name="anno_matriculacion" value="<?php if (!isset($anno_matriculacion_nuevo)) echo htmlspecialchars($anno_matriculacion);
                                                                                                                                                                                                                        else echo htmlspecialchars($anno_matriculacion_nuevo); ?>">
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
                            <input class="form-control <?php if (isset($err_kilometros)) echo 'is-invalid'; ?>" id="kilometros" type="number" placeholder="Kilómetros*" name="kilometros" value="<?php if (!isset($kilometros_nuevo)) echo $kilometros;
                                                                                                                                                                                                    else echo $kilometros_nuevo; ?>">
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
                                <option disabled selected hidden><?php if (!isset($combustible_nuevo)) echo ucfirst($combustible);
                                                                    else echo ucfirst($combustible_nuevo); ?></option>
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
                                <option disabled selected hidden><?php if (!isset($tipo_nuevo)) echo ucfirst($tipo);
                                                                    else echo ucfirst($tipo_nuevo); ?></option>
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
                                <option disabled selected hidden><?php if (!isset($transmision_nuevo)) echo ucfirst($transmision);
                                                                    else echo ucfirst($transmision_nuevo); ?></option>
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
                                <option disabled selected hidden><?php if (!isset($color_nuevo)) echo ucfirst($color_esp);
                                                                    else echo ucfirst($color_nuevo); ?></option>
                                <option value="white" <?php if (isset($_POST['color']) && $_POST['color'] == "white") echo "selected"; ?>>Blanco</option>
                                <option value="black" <?php if (isset($_POST['color']) && $_POST['color'] == "black") echo "selected"; ?>>Negro</option>
                                <option value="gray" <?php if (isset($_POST['color']) && $_POST['color'] == "gray") echo "selected"; ?>>Gris</option>
                                <option value="red" <?php if (isset($_POST['color']) && $_POST['color'] == "red") echo "selected"; ?>>Rojo</option>
                                <option value="blue" <?php if (isset($_POST['color']) && $_POST['color'] == "blue") echo "selected"; ?>>Azul</option>
                                <option value="green" <?php if (isset($_POST['color']) && $_POST['color'] == "green") echo "selected"; ?>>Verde</option>
                                <option value="yellow" <?php if (isset($_POST['color']) && $_POST['color'] == "yellow") echo "selected"; ?>>Amarillo</option>
                                <option value="orange" <?php if (isset($_POST['color']) && $_POST['color'] == "orange") echo "selected"; ?>>Naranja</option>
                                <option value="brown" <?php if (isset($_POST['color']) && $_POST['color'] == "brown") echo "selected"; ?>>Marrón</option>
                                <option value="others" <?php if (isset($_POST['color']) && $_POST['color'] == "others") echo "selected"; ?>>Otros</option>
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
                            <input class="form-control <?php if (isset($err_potencia)) echo 'is-invalid'; ?>" min="30" max="2000" id="potencia" type="number" placeholder="Potencia*" name="potencia" value="<?php if (!isset($potencia_nuevo)) echo $potencia;
                                                                                                                                                                                                                else echo $potencia_nuevo; ?>">
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
                            <input class="form-control <?php if (isset($err_numero_puertas)) echo 'is-invalid'; ?>" min="2" max="5" id="numero_puertas" type="number" placeholder="Numero de puertas*" name="numero_puertas" value="<?php if (!isset($puertas_nuevo)) echo $puertas;
                                                                                                                                                                                                                                    else echo $puertas_nuevo; ?>">
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
                            <input class="form-control <?php if (isset($err_numero_plazas)) echo 'is-invalid'; ?>" min="1" max="9" id="numero_plazas" type="number" placeholder="Numero de plazas*" name="numero_plazas" value="<?php if (!isset($plazas_nuevo)) echo $plazas;
                                                                                                                                                                                                                                else echo $plazas_nuevo; ?>">
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
                            <textarea class="form-control <?php if (isset($err_descripcion)) echo 'is-invalid'; ?>" name="descripcion" id="floatingTextarea2" rows="3" style="height: 100px" placeholder="Descripcion*"><?php if (!isset($descripcion_nuevo)) echo $descripcion;
                                                                                                                                                                                                                        else echo $descripcion_nuevo; ?></textarea>
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
                <h3 class="text-start">Precio por día</h3>

                <div class="d-flex flex-column align-items-center">
                    <label id="totalPrecio" class="form-label fw-bold">
                        Precio Diario:
                        <span id="mostrarPrecio">
                            <?php if (!isset($precio_nuevo)) echo $precio . "€";
                            else echo $precio_nuevo . "€"; ?>
                        </span>
                    </label>

                    <input type="range" class="form-range w-75 <?php if (isset($err_precio)) echo 'is-invalid'; ?>" name="precio" id="precio" min="15" max="500" step="1" value="<?php if (!isset($precio_nuevo)) echo $precio;
                                                                                                                                                                                    else echo $precio_nuevo; ?>">

                    <div class="d-flex justify-content-between text-muted mt-1 w-75">
                        <span>15€</span>
                        <span>500€</span>
                    </div>

                    <?php
                    if (isset($err_precio)) {
                        echo "<span class='error'>$err_precio</span>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Dirección y Tipo de aparcamiento -->
        <div class="container mt-5 pt-5">
            <div class="container card py-4">
                <h3 class="text-start">Ubicación del vehículo</h3>
                <div class="row justify-content-center pt-3">
                    <!-- Dirección -->
                    <div class="mb-3 col-12 col-md-6">
                        <div class="form-floating" style="position: relative;">
                            <input type="text" class="form-control <?php if (isset($err_direccion)) echo 'is-invalid'; ?>" id="autocomplete" name="direccion" placeholder="Ej: Calle Ejemplo, Ciudad, Provincia, Codigo Postal, País" autocomplete="off" value="<?php if (!isset($direccion_nuevo)) echo $direccion;
                                                                                                                                                                                                                                                                else echo $direccion_nuevo; ?>">
                            <label for="autocomplete" class="form-label">Dirección*</label>
                            <?php
                            if (isset($err_direccion)) {
                                echo "<span class='error'>$err_direccion</span>";
                                if (isset($err_extra_formato)) {
                                    echo "<span class='error'>$err_extra_formato</span>";
                                }
                            }
                            ?>
                            <div id="sugerencias" class="list-group mt-2" style="z-index:1000; position: absolute; width: 100%; max-height: 300px; overflow-y: auto; background-color: white; border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></div>
                        </div>
                    </div>

                    <!-- Tipo de aparcamiento -->
                    <div class="mb-3 col-12 col-md-6">
                        <div class="form-floating">
                            <select class="form-select <?php if (isset($err_tipo_aparcamiento)) echo 'is-invalid'; ?>" id="tipo_aparcamiento" name="tipo_aparcamiento">
                                <option disabled selected hidden><?php if (!isset($tipo_aparcamiento_nuevo)) echo ucfirst($tipo_aparcamiento);
                                                                    else echo ucfirst($tipo_aparcamiento_nuevo); ?></option>
                                <option value="calle"
                                    <?php if (isset($_POST['tipo_aparcamiento']) && $_POST['tipo_aparcamiento'] == "calle") echo "selected"; ?>>
                                    Calle
                                </option>
                                <option value="garaje"
                                    <?php if (isset($_POST['tipo_aparcamiento']) && $_POST['tipo_aparcamiento'] == "garaje") echo "selected"; ?>>
                                    Garaje
                                </option>
                                <option value="parking"
                                    <?php if (isset($_POST['tipo_aparcamiento']) && $_POST['tipo_aparcamiento'] == "parking") echo "selected"; ?>>
                                    Parking
                                </option>
                            </select>
                            <label for="tipo_aparcamiento">Tipo de aparcamiento</label>
                            <?php
                            if (isset($err_tipo_aparcamiento)) {
                                echo "<span class='error'>$err_tipo_aparcamiento</span>";
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Coordenadas ocultas -->
                <input type="hidden" name="lat" id="lat" value="<?php if (!isset($lat_nueva)) echo $lat;
                                                                else echo $lat_nueva; ?>">
                <input type="hidden" name="lon" id="lon" value="<?php if (!isset($lon_nueva)) echo $lon;
                                                                else echo $lon_nueva; ?>">
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



        <div class="row g-2 pt-3">
            <div class="col-12 col-md-6">
                <button type="button" class="btn btn-primary btn-lg w-100" data-bs-toggle="modal" data-bs-target="#miModal">
                    Extras
                </button>
            </div>
            <div class="col-12 col-md-6">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    Confirmar
                </button>
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
                                    <input type="checkbox" id="mascota" name="mascota"
                                        <?php
                                        if (!isset($mascota_nuevo)) {
                                            if ($mascota == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($mascota_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="mascota">
                                        Permito mascotas
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="fumar" name="fumar"
                                        <?php
                                        if (!isset($fumar_nuevo)) {
                                            if ($fumar == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($fumar_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="fumar">
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
                                    <input type="checkbox" id="gps" name="gps"
                                        <?php
                                        if (!isset($gps_nuevo)) {
                                            if ($gps == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($gps_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="gps">
                                        GPS
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="sensores_aparcamiento" name="sensores_aparcamiento"
                                        <?php
                                        if (!isset($sensores_aparcamiento_nuevo)) {
                                            if ($sensores_aparcamiento == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($sensores_aparcamiento_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="sensores_aparcamiento">
                                        Sensores de aparcamiento
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="camara_trasera" name="camara_trasera"
                                        <?php
                                        if (!isset($camara_trasera_nuevo)) {
                                            if ($camara_trasera == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($camara_trasera_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label>
                                        Cámara de reversa
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="control_de_crucero" name="control_de_crucero"
                                        <?php
                                        if (!isset($control_de_crucero_nuevo)) {
                                            if ($control_de_crucero == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($control_de_crucero_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="control_de_crucero">
                                        Control de crucero
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="cuatro_x_cuatro" name="cuatro_x_cuatro"
                                        <?php
                                        if (!isset($cuatro_x_cuatro_nuevo)) {
                                            if ($cuatro_x_cuatro == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($cuatro_x_cuatro_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="cuatro_x_cuatro">
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
                                    <input type="checkbox" id="baca" name="baca"
                                        <?php
                                        if (!isset($baca_nuevo)) {
                                            if ($baca == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($baca_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="baca">
                                        Baca
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="portabicicletas" name="portabicicletas"
                                        <?php
                                        if (!isset($portabicicletas_nuevo)) {
                                            if ($portabicicletas == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($portabicicletas_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="portabicicletas">
                                        Portabicicletas
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="portaequipajes" name="portaequipajes"
                                        <?php
                                        if (!isset($portaequipajes_nuevo)) {
                                            if ($portaequipajes == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($portaequipajes_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="portaequipajes">
                                        Portaequipajes
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="portaesquis" name="portaesquis"
                                        <?php
                                        if (!isset($portaesquis_nuevo)) {
                                            if ($portaesquis == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($portaesquis_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="portaesquis">
                                        Portaesquís
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="bola_remolque" name="bola_remolque"
                                        <?php
                                        if (!isset($bola_remolque_nuevo)) {
                                            if ($bola_remolque == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($bola_remolque_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="bola_remolque">
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
                                    <input type="checkbox" id="bluetooth" name="bluetooth"
                                        <?php
                                        if (!isset($bluetooth_nuevo)) {
                                            if ($bluetooth == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($bluetooth_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="bluetooth">
                                        Bluetooth
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="wifi" name="wifi"
                                        <?php
                                        if (!isset($wifi_nuevo)) {
                                            if ($wifi == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($wifi_nuevo == 1) {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="wifi">
                                        WiFi
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="android_carplay" name="android_carplay"
                                        <?php
                                        if (!isset($android_carplay_nuevo)) {
                                            if ($android_carplay == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($android_carplay_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="android_carplay">
                                        Android CarPlay
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="apple_carplay" name="apple_carplay"
                                        <?php
                                        if (!isset($apple_carplay_nuevo)) {
                                            if ($apple_carplay == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($apple_carplay_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="apple_carplay">
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
                                    <input type="checkbox" id="aire_acondicionado" name="aire_acondicionado"
                                        <?php
                                        if (!isset($aire_acondicionado_nuevo)) {
                                            if ($aire_acondicionado == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($aire_acondicionado_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="aire_acondicionado">
                                        Aire acondicionado
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="asientos_calefactables" name="asientos_calefactables"
                                        <?php
                                        if (!isset($asientos_calefactables_nuevo)) {
                                            if ($asientos_calefactables == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($asientos_calefactables_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="asientos_calefactables">
                                        Asientos calefactables
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="fijacion_isofix" name="fijacion_isofix"
                                        <?php
                                        if (!isset($fijacion_isofix_nuevo)) {
                                            if ($fijacion_isofix == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($fijacion_isofix_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="fijacion_isofix">
                                        Fijaciones ISOFIX
                                    </label>
                                </div>
                                <div>
                                    <input type="checkbox" id="movilidad_reducia" name="movilidad_reducia"
                                        <?php
                                        if (!isset($movilidad_reducida_nuevo)) {
                                            if ($movilidad_reducida == 1) {
                                                echo "checked";
                                            }
                                        } else {
                                            if ($movilidad_reducida_nuevo == "on") {
                                                echo "checked";
                                            }
                                        }
                                        ?>>
                                    <label for="movilidad_reducia">
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
    </div>
    <br>
    
    <?php include_once '../../components/footer-example.php'; ?>
    <script src="../../js/mostrar_marcas.js"></script>
    <script src="../../js/nuevo_coche.js"></script>
    <script src="../../js/pre_imagen.js"></script>
    <script src="../../js/obtener_direccion.js"></script>
    <script src="../../js/precio_coche.js"></script>
</body>

</html>