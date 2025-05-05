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
    ?>
</head>

<body>
    <?php include_once '../../components/navbar.php'; ?>
    <form action="#" method="post" enctype="multipart/form-data">
        <!-- INFORMACION DEL VEHICULO (MARCA MODELO Y ANNO DE MATRICULACION) -->

        <div class="container mt-5 pt-5">
            <div class="container card py-4">
                <h3>Imagenes</h3>
                <div class="row justify-content-center pt-3">
                    <div class="col">
                        <input class="form-control" id="img" type="file" name="img[]" multiple accept="image/png, image/jpg, image/jpeg">
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-5 pt-5">
            <div class="container card py-4">
                <h3 class="text-start">Informacion basica</h3>
                <div class="row justify-content-center pt-3">
                    <div class="col">
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

                        <select class="form-select" id="marca" name="marca">
                            <option disabled selected hidden>Marca*</option>
                            <?php foreach ($marcas as $marcaItem) { ?>
                                <option value="<?php echo $marcaItem["MakeName"]; ?>"
                                    <?php if (isset($_POST['marca']) && $_POST['marca'] == $marcaItem["MakeName"]) echo "selected"; ?>>
                                    <?php echo $marcaItem["MakeName"]; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <?php
                        if (isset($err_marca)) {
                            echo "<span class='error'>$err_marca</span>";
                        }
                        ?>
                    </div>
                    <div class="col">
                        <select class="form-select" id="modelo" name="modelo" data-selected="<?php echo htmlspecialchars($modeloSeleccionado); ?>">
                            <option disabled selected hidden>Modelo*</option>
                        </select>
                        <?php
                        if (isset($err_modelo)) {
                            echo "<span class='error'>$err_modelo</span>";
                        }
                        ?>
                    </div>
                    <div class="col">
                        <input class="form-control" placeholder="Año de matriculacion" id="inputMes" type="month" name="anno_matriculacion" value="<?php if (isset($_POST['anno_matriculacion'])) echo htmlspecialchars($_POST['anno_matriculacion']); ?>">
                    </div>
                </div>


            </div>
        </div>



        <div class="container mt-5 pt-5">
            <div class="container card py-4">
                <h3 class="text-start">MATRICULA</h3>
                <div class="row justify-content-center pt-3">
                    <div class="col">
                        <input class="form-control" id="matricula" type="text" placeholder="Matricula*" name="matricula" value="">
                    </div>
                </div>


            </div>
        </div>



        <div class="container mt-5 pt-5">

            <div class="container card">
                <br>
                <h3>Informacion del vehiculo</h3>
                <div class="row justify-content-center pt-3">
                    <div class="mb-3 col-6">
                        <input class="form-control" id="kilometros" type="number" placeholder="Kilómetros*" name="kilometros" value="">
                    </div>
                    <div class="mb-3 col-6">
                        <Select class="form-select" id="tipo_combustible" name="tipo_combustible">
                            <option disabled selected hidden>Tipo de combustible*</option>
                            <option value="gasolina">
                                Gasolina
                            </option>
                            <option value="diesel">
                                Diesel
                            </option>
                            <option value="hibrido">
                                Hibrido
                            </option>
                            <option value="electrico">
                                Eléctrico
                            </option>
                            <option value="glp">
                                GLP
                            </option>
                            <option value="gnc">
                                GNC
                            </option>
                        </Select>
                    </div>

                    <div class="mb-3 col-6">
                        <select class="form-select" id="tipo" name="tipo">
                            <option disabled selected hidden>Tipo de coche*</option>
                            <option value="berlina">
                                Berlina
                            </option>
                            <option value="coupe">
                                Coupé
                            </option>
                            <option value="deportivo">
                                Deportivo
                            </option>
                            <option value="furgoneta">
                                Furgoneta
                            </option>
                            <option value="monovolumen">
                                Monovolumen
                            </option>
                            <option value="suv">
                                SUV
                            </option>
                            <option value="pick-up">
                                Pick-up
                            </option>
                            <option value="roadster">
                                Roadster
                            </option>
                            <option value="utilitario">
                                Utilitario
                            </option>
                            <option value="familiar">
                                Familiar
                            </option>
                            <option value="autocaravana">
                                Autocaravana
                            </option>
                        </select>

                    </div>
                    <div class="mb-3 col-6">
                        <Select class="form-select" id="transmision" name="transmision">
                            <option disabled selected hidden>Transmisión*</option>
                            <option value="manual">
                                Manual
                            </option>
                            <option value="automatico">
                                Automática
                            </option>
                        </Select>

                    </div>
                    <div class="mb-3 col-6">
                        <select class="form-select" id="color" name="color" required>
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
                    </div>
                    <div class="mb-3 col-6">
                        <input class="form-control" id="potencia" type="number" placeholder="caballos*" name="Potencia" value="">
                    </div>
                    <div class="mb-3 col-6">
                        <input class="form-control" id="numero_puertas" type="number" placeholder="Numero de puertas*" name="numero_puertas" value="">
                    </div>
                    <div class="mb-3 col-6">
                        <input class="form-control" id="numero_plazas" type="number" placeholder="Numero de plazas*" name="numero_plazas" value="">
                    </div>
                    <div>
                        <textarea class="form-control" name="descripcion" id="exampleFormControlTextarea1" rows="3" placeholder="Descripcion*"></textarea>
                        <br>
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



        <div class="container mt-5 pt-5">
            <div class="container card py-4">
                <h3 class="text-start">Ubicacion</h3>
                <div class="row justify-content-center pt-3">
                    <div class="mb-3 col-6">
                        <input class="form-control" id="direccion" type="text" placeholder="Direccion*" name="direccion" value="">

                    </div>
                    <div class="mb-3 col-6">
                        <input class="form-control" id="cp" type="number" placeholder="Código Postal*" name="cp" value="">

                    </div>
                    <div class="mb-3 col-6">
                        <input class="form-control" id="provincia" type="text" placeholder="Provincia*" name="provincia" value="">
 
                    </div>
                    <div class="mb-3 col-6">
                        <input class="form-control" id="ciudad" type="text" placeholder="Ciudad*" name="ciudad" value="">

                    </div>
                    <div class="mb-3 col-6">
                        <Select class="form-select" id="tipo_aparcamiento" name="tipo_aparcamiento">
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
                                <input type="checkbox" name="portabicicletas" >
                                <label>
                                    Portabicicletas
                                </label>
                            </div>
                            <div>
                                <input type="checkbox" name="portaequipajes" >
                                <label>
                                    Portaequipajes
                                </label>
                            </div>
                            <div>
                                <input type="checkbox" name="portaesquis" >
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
                                <input type="checkbox" name="bluetooth" >
                                <label>
                                    Bluetooth
                                </label>
                            </div>
                            <div>
                                <input type="checkbox" name="wifi" >
                                <label>
                                    WiFi
                                </label>
                            </div>
                            <div>
                                <input type="checkbox" name="android_carplay" >
                                <label>
                                    Android CarPlay
                                </label>
                            </div>
                            <div>
                                <input type="checkbox" name="apple_carplay" >
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
                                <input type="checkbox" name="aire_acondicionado" >
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

</body>

</html>