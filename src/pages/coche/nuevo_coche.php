<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        require(__DIR__ . "/../../config/conexion.php");

        session_start();
        if (!isset($_SESSION["usuario"])) {
            header("location: ../../../index.php");
            exit();
        }
    ?>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <?php 
        require(__DIR__ . "/../../config/depurar.php");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tmp_matricula = depurar($_POST['matricula']);

            if (isset($_POST['marca'])) {
                $tmp_marca = depurar($_POST['marca']);
            } else {
                $tmp_marca = "";
            }

            if (isset($_POST['modelo'])) {
                $tmp_modelo = depurar($_POST['modelo']);
            } else {
                $tmp_modelo = "";
            }

            $tmp_anno_matriculacion = depurar($_POST['anno_matriculacion']);
            $tmp_kilometros = depurar($_POST['kilometros']);
            $tmp_direccion = depurar($_POST['direccion']);
            $tmp_cp = depurar($_POST['cp']);
            $tmp_provincia = depurar($_POST['provincia']);
            $tmp_ciudad = depurar($_POST['ciudad']);

            

            if (isset($_POST['movilidadreducia']) && $_POST['movilidadreducia'] == 'on') {
                $movilidadreducia = 1;
            } else {
                $movilidadreducia = 0;
            }
            
            if (isset($_POST['gps']) && $_POST['gps'] == 'on') {
                $gps = 1;
            } else {
                $gps = 0;
            }
            
            if (isset($_POST['wifi']) && $_POST['wifi'] == 'on') {
                $wifi = 1;
            } else {
                $wifi = 0;
            }
            
            if (isset($_POST['sensoresaparcamiento']) && $_POST['sensoresaparcamiento'] == 'on') {
                $sensoresaparcamiento = 1;
            } else {
                $sensoresaparcamiento = 0;
            }
            
            if (isset($_POST['camaradereversa']) && $_POST['camaradereversa'] == 'on') {
                $camaradereversa = 1;
            } else {
                $camaradereversa = 0;
            }
            
            if (isset($_POST['controldecrucero']) && $_POST['controldecrucero'] == 'on') {
                $controldecrucero = 1;
            } else {
                $controldecrucero = 0;
            }
            
            if (isset($_POST['asientoscalefactables']) && $_POST['asientoscalefactables'] == 'on') {
                $asientoscalefactables = 1;
            } else {
                $asientoscalefactables = 0;
            }
            
            if (isset($_POST['bola_remolque']) && $_POST['bola_remolque'] == 'on') {
                $bola_remolque = 1;
            } else {
                $bola_remolque = 0;
            }
            
            if (isset($_POST['fijaciones_isofix']) && $_POST['fijaciones_isofix'] == 'on') {
                $fijaciones_isofix = 1;
            } else {
                $fijaciones_isofix = 0;
            }
            
            if (isset($_POST['apple_carplay']) && $_POST['apple_carplay'] == 'on') {
                $apple_carplay = 1;
            } else {
                $apple_carplay = 0;
            }
            
            if (isset($_POST['android_carplay']) && $_POST['android_carplay'] == 'on') {
                $android_carplay = 1;
            } else {
                $android_carplay = 0;
            }
            
            if (isset($_POST['baca']) && $_POST['baca'] == 'on') {
                $baca = 1;
            } else {
                $baca = 0;
            }
            
            if (isset($_POST['portabicicletas']) && $_POST['portabicicletas'] == 'on') {
                $portabicicletas = 1;
            } else {
                $portabicicletas = 0;
            }
            
            if (isset($_POST['portaequipajes']) && $_POST['portaequipajes'] == 'on') {
                $portaequipajes = 1;
            } else {
                $portaequipajes = 0;
            }
            
            if (isset($_POST['portaesquis']) && $_POST['portaesquis'] == 'on') {
                $portaesquis = 1;
            } else {
                $portaesquis = 0;
            }
            
            if (isset($_POST['bluetooth']) && $_POST['bluetooth'] == 'on') {
                $bluetooth = 1;
            } else {
                $bluetooth = 0;
            }
            
            if (isset($_POST['cuatroxcuatro']) && $_POST['cuatroxcuatro'] == 'on') {
                $cuatroxcuatro = 1;
            } else {
                $cuatroxcuatro = 0;
            }
            
            if (isset($_POST['mascota']) && $_POST['mascota'] == 'on') {
                $mascota = 1;
            } else {
                $mascota = 0;
            }
            
            if (isset($_POST['fumar']) && $_POST['fumar'] == 'on') {
                $fumar = 1;
            } else {
                $fumar = 0;
            }
            
            if (isset($_POST['seguro']) && $_POST['seguro'] == 'on') {
                $seguro = 1;
            } else {
                $seguro = 0;
            }            

            if (isset($_POST['tipo_combustible'])) {
                $tmp_tipo_combustible = depurar($_POST['tipo_combustible']);
            } else {
                $tmp_tipo_combustible = "";
            }

            if (isset($_POST['transmision'])) {
                $tmp_transmision = depurar($_POST['transmision']);
            } else {
                $tmp_transmision = "";
            }

            if (isset($_POST['tipo_aparcamiento'])) {
                $tmp_tipo_aparcamiento = depurar($_POST['tipo_aparcamiento']);
            } else {
                $tmp_tipo_aparcamiento = "";
            }

            if (isset($_POST['tipo'])) {
                $tmp_tipo = depurar($_POST['tipo']);
            } else {
                $tmp_tipo = "";
            }

            $id_usuario = $_SESSION["usuario"]["identificacion"];

            /* Validación de matricula */
            if ($tmp_matricula == "") {
                $err_matricula = "Debes indicar la matricula de tu coche";
            } else {
                $sql = "SELECT * FROM coche WHERE matricula = '$tmp_matricula'";
                $resultado = $_conexion->query($sql);
                if ($resultado -> num_rows == 1) {
                    $err_matricula = "Ya existe un coche con esta matricula";
                } else {
                    if (strlen($tmp_matricula) > 7) {
                        $err_matricula = "La matricula no puede tener más de 7 caracteres";
                    } else {
                        if (!preg_match("/^[0-9]{4}[A-Z]{3}$/", $tmp_matricula)) {
                            $err_matricula = "La matricula no es válida";
                        } else {
                            $matricula = $tmp_matricula;
                        }
                    }
                }
            }

            /* Validación de marca */
            if ($tmp_marca == "") {
                $err_marca = "Debes indicar la marca de tu coche";
            } else {
                if (strlen($tmp_marca) > 20) {
                    $err_marca = "La marca no puede tener más de 20 caracteres";
                } else {
                    $marca = $tmp_marca; /* Agregar más adelante la comprovación con la API de las marcas */
                }
            }

            /* Validación de modelo */
            if ($tmp_modelo == "") {
                $err_modelo = "Debes indicar el modelo de tu coche";
            } else {
                if (strlen($tmp_modelo) > 20) {
                    $err_modelo = "El modelo no puede tener más de 20 caracteres";
                } else {
                    $modelo = $tmp_modelo; /* Agregar más adelante la comprovación con la API de los modelos */
                    $ruta_img_coche = __DIR__ . "/../../../clients/img/coche/" . $_SESSION["usuario"]["identificacion"] . "/" . $marca . "_" . $modelo ."/";
                }
            }

            /* Validación de año de matriculación */
            if ($tmp_anno_matriculacion == "") {
                $err_anno_matriculacion = "Debes indicar el año de matriculación de tu coche";
            } else {
                $anno_matriculacion = $tmp_anno_matriculacion . "-01";
            }

            /* Validación de kilómetros */
            if ($tmp_kilometros == "") {
                $err_kilometros = "Debes indicar los kilómetros de tu coche";
            } else {
                if (!is_numeric($tmp_kilometros)) {
                    $err_kilometros = "Los kilómetros deben ser un número";
                } else {
                    $kilometros = $tmp_kilometros;
                }
            }

            /* Validación de dirección */
            if ($tmp_direccion == "") {
                $err_direccion = "Debes indicar la dirección de tu coche";
            } else {
                if (strlen($tmp_direccion) > 50) {
                    $err_direccion = "La dirección no puede tener más de 50 caracteres";
                } else {
                    $direccion = $tmp_direccion;
                }
            }
            
            /* Validación de código postal */
            if ($tmp_cp == "") {
                $err_cp = "Debes indicar el código postal de tu coche";
            } else {
                if (!is_numeric($tmp_cp)) {
                    $err_cp = "El código postal debe ser un número";
                } else {
                    if (strlen($tmp_cp) != 5) {
                        $err_cp = "El código postal debe tener 5 dígitos";
                    } else {
                        $cp = $tmp_cp;
                    }
                }
            }

            /* Validación de provincia */
            if ($tmp_provincia == "") {
                $err_provincia = "Debes indicar la provincia de tu coche";
            } else {
                if (strlen($tmp_provincia) > 20) {
                    $err_provincia = "La provincia no puede tener más de 20 caracteres";
                } else {
                    $provincia = $tmp_provincia; /* Agregar más adelante la comprovación con la API de las provincias */
                }
            }

            /* Validación de ciudad */
            if ($tmp_ciudad == "") {
                $err_ciudad = "Debes indicar la ciudad de tu coche";
            } else {
                if (strlen($tmp_ciudad) > 20) {
                    $err_ciudad = "La ciudad no puede tener más de 20 caracteres";
                } else {
                    $ciudad = $tmp_ciudad; /* Agregar más adelante la comprovación con la API de las ciudades */
                }
            }

            /* Validación de tipo de combustible */
            if ($tmp_tipo_combustible == "") {
                $err_tipo_combustible = "Debes indicar el tipo de combustible de tu coche";
            } else {
                $lista_combustibles = ["gasolina", "diesel", "hibrido", "electrico", "glp", "gnc"];
                if (!in_array($tmp_tipo_combustible, $lista_combustibles)) {
                    $err_tipo_combustible = "El tipo de combustible no es válido";
                } else {
                    $tipo_combustible = $tmp_tipo_combustible;
                }
            }

            /* Validación del tipo de coche */
            if ($tmp_tipo == "") {
                $err_tipo = "Debes indicar de que tipo es tu coche";
            } else {
                $lista_tipos = ["berlina", "coupe", "monovolumen", "suv", "familiar", "furgoneta", "utilitario", "autocaravana"];
                if (!in_array($tmp_tipo, $lista_tipos)) {
                    $err_tipo = "El tipo de coche no es válido";
                } else {
                    $tipo = $tmp_tipo;
                }
            }

            /* Validación de transmisión */
            if ($tmp_transmision == "") {
                $err_transmision = "Debes indicar la transmisión de tu coche";
            } else {
                $lista_transmision = ["manual", "automatico"];
                if (!in_array($tmp_transmision, $lista_transmision)) {
                    $err_transmision = "El tipo de transmisión no es válido";
                } else {
                    $transmision = $tmp_transmision;
                }
            }

            /* Validación de tipo de aparcamiento */
            if ($tmp_tipo_aparcamiento == "") {
                $err_tipo_aparcamiento = "Debes indicar el tipo de aparcamiento de tu coche";
            } else {
                $lista_aparcamiento = ["calle", "garaje", "parking"];
                if (!in_array($tmp_tipo_aparcamiento, $lista_aparcamiento)) {
                    $err_tipo_aparcamiento = "El tipo de aparcamiento no es válido";
                } else {
                    $tipo_aparcamiento = $tmp_tipo_aparcamiento;
                }
            }

            /* Validación de fotos */

        }
    ?>

    <?php include_once '../../components/navbar.php'; ?>

    <form action="#" method="post">
        <div class="container card text-center card_registro" style="width: 40rem;">
            <h1 class="register">Añadir coche</h1>
                <div class="row justify-content-center">

                    <div class="mb-3 col-4">
                        <input id="matricula" class="form-control" type="text" placeholder="Matricula*" name="matricula" value="<?php if (isset($matricula)) echo "$matricula" ?>">
                        <?php 
                            if(isset($err_matricula)){
                                echo "<span class='error'>$err_matricula</span>";
                            }
                        ?>
                    </div>

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
                    ?>

                    <div class="row justify-content-center">
                        <div class="mb-3 col-4">
                            <select id="marca" name="marca" class="form-select">
                                <option disabled selected hidden>Marca*</option>
                                <?php foreach ($marcas as $marca) { ?>
                                    <option value="<?php echo $marca["MakeName"]; ?>" 
                                        <?php if (isset($_POST['marca']) && $_POST['marca'] == $marca["MakeName"]) echo "selected"; ?>>
                                        <?php echo $marca["MakeName"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <?php 
                                if(isset($err_marca)){
                                    echo "<span class='error'>$err_marca</span>";
                                }
                            ?>
                        </div>

                        <div class="mb-3 col-4">
                            <select id="modelo" name="modelo" class="form-select">
                                <option disabled selected hidden>Modelo*</option>
                                <!-- Aquí los modelos se cargarán dinámicamente -->
                            </select>
                            <?php 
                                if(isset($err_modelo)){
                                    echo "<span class='error'>$err_modelo</span>";
                                }
                            ?>
                        </div>
                    </div>

                    <div class="mb-3 col-8">
                        <input id="anno_matriculacion" class="form-control" type="month" name="anno_matriculacion" value="<?php if (isset($_POST['anno_matriculacion'])) echo htmlspecialchars($_POST['anno_matriculacion']); ?>" 
                            placeholder="Año de matriculación*"
                        >
                        <?php 
                            if (isset($err_anno_matriculacion)) {
                                echo "<span class='error'>$err_anno_matriculacion</span>";
                            }
                        ?>
                    </div>

                    <div class="mb-3 col-8">
                        <input id="kilometros" class="form-control" type="number" placeholder="Kilómetros*" name="kilometros" value="<?php if (isset($kilometros)) echo "$kilometros" ?>">
                        <?php 
                            if(isset($err_kilometros)){
                                echo "<span class='error'>$err_kilometros</span>";
                            }
                        ?>
                    </div>

                    <div class="mb-3 col-8">
                        <input id="direccion" class="form-control" type="text" placeholder="Direccion*" name="direccion" value="<?php if (isset($direccion)) echo "$direccion" ?>">
                        <?php 
                            if(isset($err_direccion)){
                                echo "<span class='error'>$err_direccion</span>";
                            }
                        ?>
                    </div>
                    <div class="mb-3 col-8">
                        <input id="cp" class="form-control" type="number" placeholder="Código Postal*" name="cp" value="<?php if (isset($cp)) echo "$cp" ?>">
                        <?php 
                            if(isset($err_cp)){
                                echo "<span class='error'>$err_cp</span>";
                            }
                        ?>
                    </div>
                    <div class="mb-3 col-8">
                        <input id="provincia" class="form-control" type="text" placeholder="Provincia*" name="provincia" value="<?php if (isset($provincia)) echo "$provincia" ?>">
                        <?php 
                            if(isset($err_provincia)){
                                echo "<span class='error'>$err_provincia</span>";
                            }
                        ?>
                    </div>
                    <div class="mb-3 col-8">
                        <input id="ciudad" class="form-control" type="text" placeholder="Ciudad*" name="ciudad" value="<?php if (isset($ciudad)) echo "$ciudad" ?>">
                        <?php 
                            if(isset($err_ciudad)){
                                echo "<span class='error'>$err_ciudad</span>";
                            }
                        ?>
                    </div>
                    
                    <div class="mb-3 col-8">
                        <Select id="tipo_combustible" name="tipo_combustible" class="form-select">
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
                                Hibrido
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
                        </Select>
                        <?php 
                            if(isset($err_tipo_combustible)){
                                echo "<span class='error'>$err_tipo_combustible</span>";
                            }
                        ?>
                    </div>

                    <div class="mb-3 col-8">
                        <select id="tipo" name="tipo" class="form-select">
                            <option disabled selected hidden>Tipo de coche*</option>
                            <option value="berlina" 
                                <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "berlina") echo "selected"; ?>>
                                Berlina
                            </option>
                            <option value="coupe" 
                                <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "coupe") echo "selected"; ?>>
                                Coupé
                            </option>
                            <option value="monovolumen" 
                                <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "monovolumen") echo "selected"; ?>>
                                Monovolumen
                            </option>
                            <option value="suv" 
                                <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "suv") echo "selected"; ?>>
                                SUV
                            </option>
                            <option value="familiar" 
                                <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "familiar") echo "selected"; ?>>
                                Familiar
                            </option>
                            <option value="furgoneta" 
                                <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "furgoneta") echo "selected"; ?>>
                                Furgoneta
                            </option>
                            <option value="utilitario" 
                                <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "utilitario") echo "selected"; ?>>
                                Utilitario
                            </option>
                            <option value="autocaravana" 
                                <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "autocaravana") echo "selected"; ?>>
                                Autocaravana
                            </option>
                        </select>
                        <?php 
                            if(isset($err_tipo)){
                                echo "<span class='error'>$err_tipo</span>";
                            }
                        ?>
                    </div>

                    <div class="mb-3 col-8">
                        <Select id="transmision" name="transmision" class="form-select">
                            <option disabled selected hidden>Transmisión*</option>
                            <option value="manual" 
                                <?php if (isset($_POST['transmision']) && $_POST['transmision'] == "manual") echo "selected"; ?>>
                                Manual
                            </option>
                            <option value="automatico" 
                                <?php if (isset($_POST['transmision']) && $_POST['transmision'] == "automatico") echo "selected"; ?>>
                                Automática
                            </option>
                        </Select>
                        <?php 
                            if(isset($err_transmision)){
                                echo "<span class='error'>$err_transmision</span>";
                            }
                        ?>
                    </div>


                    <div class="mb-3 col-8">
                        <Select id="tipo_aparcamiento" name="tipo_aparcamiento" class="form-select">
                            <option disabled selected hidden>Tipo de aparcamiento*</option>
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
                                parking
                            </option>
                        </Select>
                        <?php 
                            if(isset($err_tipo_aparcamiento)){
                                echo "<span class='error'>$err_tipo_aparcamiento</span>";
                            }
                        ?>
                    </div>

                    <!-- INICIO SECCION DE IMAGENES -->
                    
                    <!-- FIN SECCION DE IMAGENES -->

                </div>
                <!--BOTON VENTANA MODAL CON BOOTSTRAP-->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">
                    Extras
                </button>

            <!--BOTON PARA ENVIAR EL FORMULARIO -->
            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">
                Confirmar
            </button>
        </div>
        </div>

        <!-- VENTANA MODAL CON BOOTSTRAP -->
        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="miModalLabel">Seleciona los extras</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group checkbox-group row">
                        <label class="col-6">
                            <input type="checkbox" name="aire_acondicionado" <?php if (isset($_POST['aire_acondicionado'])) echo 'checked'; ?>>
                            Aire acondicionado
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="gps" <?php if (isset($_POST['gps'])) echo 'checked'; ?>>
                            GPS
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="wifi" <?php if (isset($_POST['wifi'])) echo 'checked'; ?>>
                            Wifi
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="sensoresaparcamiento" <?php if (isset($_POST['sensoresaparcamiento'])) echo 'checked'; ?>>
                            Sensores de aparcamiento
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="cuatroxcuatro" <?php if (isset($_POST['cuatroxcuatro'])) echo 'checked'; ?>>
                            4x4
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="camaradereversa" <?php if (isset($_POST['camaradereversa'])) echo 'checked'; ?>>
                            Cámara de reversa
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="controldecrucero" <?php if (isset($_POST['controldecrucero'])) echo 'checked'; ?>>
                            Control de crucero
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="asientoscalefactables" <?php if (isset($_POST['asientoscalefactables'])) echo 'checked'; ?>>
                            Asientos calefactables
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="mascota" <?php if (isset($_POST['mascota'])) echo 'checked'; ?>>
                            Mascota permitida
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="fumar" <?php if (isset($_POST['fumar'])) echo 'checked'; ?>>
                            Se permite fumar
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="movilidadreducia" <?php if (isset($_POST['movilidadreducia'])) echo 'checked'; ?>>
                            Movilidad reducida
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="bola_remolque" <?php if (isset($_POST['bola_remolque'])) echo 'checked'; ?>>
                            Bola de remolque
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="fijaciones_isofix" <?php if (isset($_POST['fijaciones_isofix'])) echo 'checked'; ?>>
                            Fijaciones ISOFIX
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="android_carplay" <?php if (isset($_POST['android_carplay'])) echo 'checked'; ?>>
                            Android CarPlay
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="apple_carplay" <?php if (isset($_POST['apple_carplay'])) echo 'checked'; ?>>
                            Apple CarPlay
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="baca" <?php if (isset($_POST['baca'])) echo 'checked'; ?>>
                            Baca
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="portabicicletas" <?php if (isset($_POST['portabicicletas'])) echo 'checked'; ?>>
                            Portabicicletas
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="portaequipajes" <?php if (isset($_POST['portaequipajes'])) echo 'checked'; ?>>
                            Portaequipajes
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="portaesquis" <?php if (isset($_POST['portaesquis'])) echo 'checked'; ?>>
                            Portaesquís
                        </label>
                        <label class="col-6">
                            <input type="checkbox" name="bluetooth" <?php if (isset($_POST['bluetooth'])) echo 'checked'; ?>>
                            Bluetooth
                        </label>
                        </div>
                    </div>


                    <!--BOTON CERRAR DE LA VENTANA MODAL-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
        if (isset($matricula, $marca) && isset($modelo) && isset($anno_matriculacion) && isset($kilometros) && isset($direccion) && isset($cp) && isset($provincia) && isset($ciudad) && isset($tipo_combustible) && isset($transmision) && isset($tipo_aparcamiento) && isset($tipo)) {
            $enviar = $_conexion->prepare("INSERT INTO coche (
                matricula, id_usuario, seguro, marca, modelo, anno_matriculacion, kilometros,
                combustible, transmision, provincia, ciudad, codigo_postal, direccion,
                tipo_aparcamiento, mascota, fumar, ruta_img_coche, movilidadreducia, gps,
                wifi, sensoresaparcamiento, camaradereversa, controldecrucero,
                asientoscalefactables, bola_remolque, fijaciones_isofix, apple_carplay,
                android_carplay, baca, portabicicletas, portaequipajes, portaesquis,
                bluetooth, cuatroxcuatro, tipo
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if (is_array($marca) && isset($marca['MakeName'])) {
                $marca = $marca['MakeName'];
            }

            if (is_array($modelo) && isset($modelo['Model_Name'])) {
                $modelo = $modelo['Model_Name'];
            }
            
            $enviar->bind_param(
                "ssisssissssissiisiiiiiiiiiiiiiiiiis",
                $matricula, $id_usuario, $seguro, $marca, $modelo, $anno_matriculacion, $kilometros,
                $tipo_combustible, $transmision, $provincia, $ciudad, $cp, $direccion,
                $tipo_aparcamiento, $mascota, $fumar, $ruta_img_coche, $movilidadreducia, $gps,
                $wifi, $sensoresaparcamiento, $camaradereversa, $controldecrucero,
                $asientoscalefactables, $bola_remolque, $fijaciones_isofix, $apple_carplay,
                $android_carplay, $baca, $portabicicletas, $portaequipajes, $portaesquis,
                $bluetooth, $cuatroxcuatro, $tipo
            );
        
            // Ejecuta la consulta
            $enviar->execute();
            echo "<script>alert('Coche añadido correctamente');</script>";
        }
    ?>
    <?php include_once '../../components/footer.php'; ?>
</body>
</html>