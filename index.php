<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
require(__DIR__ . "/src/config/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>
    <link rel="icon" href="src/img/favicon.png" />
    <?php include_once 'src/components/links.php'; ?>
</head>
<style>
    #opciones-equipamiento {
        display: none;
        margin-top: -2vh;
        margin-left: 4vh;
    }

    .equipamiento {
        cursor: pointer;
        display: flex;
        align-items: center;
        margin-bottom: 3vh;
    }

    .flecha {
        margin-left: 8px;
        font-size: 10px;
        color: black;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .flecha.girada {
        transform: rotate(90deg);
    }

    .form-label {
        font-weight: bold;
    }

    .banner-video-container {
        position: relative;
        height: 60vh;
        overflow: hidden;
    }

    .banner-video {
        position: absolute;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        transform: translate(-50%, -50%);
        object-fit: cover;
        z-index: 1;
    }

    .banner-content {
        position: relative;
        z-index: 2;
    }

    .busqueda {
        margin-top: 10vh;
    }
</style>

<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR -->
    <?php include_once 'src/components/navbar.php'; ?>

    <!-- BANNER (Hero) -->
    
    <div class="banner-video-container d-flex justify-content-center align-items-center text-center">
        <video autoplay muted loop playsinline class="banner-video">
            <source src="/socialicar/src/video/socialicar_3.mp4" type="video/mp4" />
            Tu navegador no soporta el video HTML5.
        </video>
        <div class="banner-content text-white">
            <h1>Encuentra tu vehículo ideal</h1>
            <h3>Alquila vehículos de forma segura</h3>
        </div>
    </div>
    <!-- BARRA DE BUSQUEDA -->
    <form class="w-75 mx-auto busqueda">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Buscar un vehículo...">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>
    <br><br>

    <!-- MENU DE FILTROS DEL COCHE -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 border-top border-end border-bottom pe-3">
                <h3>Filtros</h3>
                <!-- MARCA -->
                <div>
                    <label class="form-label">Marca:</label>
                    <select class="form-select">
                        <option selected>- - Selecciona un tipo - -</option>
                        <option value="1">Alfa Romeo</option>
                        <option value="2">Volkswagen</option>
                        <option value="3">BMW</option>
                        <option value="4">Mercedes</option>
                        <option value="5">Nissan</option>
                        <!-- API coches para marcas -->
                    </select>
                </div><br>

                <!-- MODELO -->
                <div>
                    <label class="form-label">Modelo:</label>
                    <select class="form-select">
                        <option selected>- - Selecciona un tipo - -</option>
                        <option value="1">Modelo</option>
                        <!-- API coches para modelos QUE CAMBIARAN SEGUN LA MARCA-->
                    </select>
                </div><br>

                <!-- CIUDAD -->
                <div>
                    <label for="ciudad" class="form-label">Ubicación:</label>
                    <select id="ciudad" class="form-select">
                        <option selected>- - Selecciona una ciudad - -</option>
                        <option value="1">Málaga</option>
                        <option value="2">Granada</option>
                        <option value="3">Madrid</option>
                        <option value="4">Valencia</option>
                        <option value="5">Barcelona</option>
                    </select>
                </div><br>

                <!-- TIPO -->
                <div>
                    <label class="form-label">Tipo de Coche:</label>
                    <select class="form-select">
                        <option selected>- - Selecciona un tipo - -</option>
                        <option value="1">Berlina</option>
                        <option value="2">Coupé</option>
                        <option value="3">Monovolumen</option>
                        <option value="4">SUV</option>
                        <option value="5">Familiar</option>
                        <option value="6">Furgoneta</option>
                        <option value="7">Utilitario</option>
                        <option value="8">Autocaravana</option>
                    </select>
                </div><br>

                <!-- COMBUSTIBLE -->
                <div>
                    <label class="form-label">Combustible:</label>
                    <select class="form-select">
                        <option selected>- - Selecciona un tipo - -</option>
                        <option value="Diésel">Diésel</option>
                        <option value="Gasolina">Gasolina</option>
                        <option value="Eléctrico">Eléctrico</option>
                        <option value="Híbrido">Híbrido</option>
                    </select>
                </div><br>

                <!-- PRECIO -->
                <div>
                    <label class="form-label">Precio Diario (€):</label>

                    <input type="range" class="form-range" id="precio" min="0" max="500" step="10">

                    <div class="d-flex justify-content-between"> <!-- separación -->
                        <span>€0</span>
                        <span>€500</span>
                    </div>
                </div><br>


                <!-- FECHAS (DISPONIBILIDAD) HABRA QUE EL FIN NO SEA ANTERIOR AL INICIO-->
                <div>
                    <label class="form-label">Disponibilidad</label>
                    <div class="d-flex gap-2">
                        <div class="flex-fill">
                            <label class="form-label">Inicio</label>
                            <input type="date" class="form-control" id="FechaInicio" />
                        </div>
                        <div class="flex-fill">
                            <label class="form-label">Fin</label>
                            <input type="date" class="form-control" id="FechaFin" />
                        </div>
                    </div>
                </div><br>

                <!-- OTROS FILTROS -->
                <!-- mascotas -->
                <div>
                    <label class="form-label">Mascotas:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="mascotas">
                        <label class="form-check-label">Acepta mascotas</label>
                    </div>
                </div><br>
                <!-- movilidad -->
                <div>
                    <label class="form-label">Movilidad reducida:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="movilidad_reducida">
                        <label class="form-check-label">Adaptado para movilidad reducida</label>
                    </div>
                </div><br>
                <!-- fumador -->
                <div>
                    <label class="form-label">Fumadores:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="fumadores">
                        <label class="form-check-label">Acepta fumadores</label>
                    </div>
                </div><br>

                <!-- EQUIPAMIENTO -->
                <div>
                    <div class="equipamiento" onclick="Equipamiento()">
                        <b>Equipamiento</b> <i id="flecha" class="fas fa-chevron-right flecha"></i>
                    </div>

                    <div id="opciones-equipamiento">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bluetooh">
                            <label class="form-check-label">Bluetooh</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="wifi">
                            <label class="form-check-label">WiFi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="camara_reversa">
                            <label class="form-check-label">Cámara reversa</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sensor_aparcamiento">
                            <label class="form-check-label">Sensor de aparcamiento</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="control_crucero">
                            <label class="form-check-label">Control crucero</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="asiento_calefactable">
                            <label class="form-check-label">Asiento calefactable</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bola_remolque">
                            <label class="form-check-label">Bola de remolque</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="4x4">
                            <label class="form-check-label">4x4</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="baca">
                            <label class="form-check-label">Baca</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fijaciones_isofix">
                            <label class="form-check-label">Fijaciones isofix</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gps">
                            <label class="form-check-label">GPS</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="aire_acondicionado">
                            <label class="form-check-label">Aire Acondicionado</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="portabicicletas">
                            <label class="form-check-label">Portabicicletas</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="portaequipajes">
                            <label class="form-check-label">Portaequipajes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="portaesquís">
                            <label class="form-check-label">Portaesquís</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="android_carplay">
                            <label class="form-check-label">Android Carplay</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="apple_carplay">
                            <label class="form-check-label">Apple Carplay</label>
                        </div>
                    </div>
                </div>


                <!-- APLICAR FILTROS -->
                <div>
                    <button class="btn btn-primary" type="button">Aplicar Filtros</button>
                </div>
            </div> <!-- fin del menu -->


            <!-- TARJETAS DE LOS USUARIOS PREMIUM -->


            <div class="col-md-10 bg-light">


                <div class="container my-4">
                    <!-- TARJETAS -->

                    <!-- tarjetas premium -->
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <!-- 1 -->
                        <div class="col">
                            <div class="card h-100 shadow-lg border-success">
                                <img src="./ruta" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Modelo del Vehículo</h5>
                                    <p class="card-text"><strong>Marca del coche</strong></p>
                                    <p class="card-text text-success">45€/día</p>
                                    <p class="badge bg-warning">¡Premium!</p>
                                </div>
                            </div>
                        </div>
                        <!-- 2 -->
                        <div class="col">
                            <div class="card h-100 shadow-lg border-success">
                                <img src="./ruta" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Modelo del Vehículo</h5>
                                    <p class="card-text"><strong>Marca del coche</strong></p>
                                    <p class="card-text text-success">45€/día</p>
                                    <p class="badge bg-warning">¡Premium!</p>
                                </div>
                            </div>
                        </div>
                        <!-- 3 -->
                        <div class="col">
                            <div class="card h-100 shadow-lg border-success">
                                <img src="./ruta" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Modelo del Vehículo</h5>
                                    <p class="card-text"><strong>Marca del coche</strong></p>
                                    <p class="card-text text-success">45€/día</p>
                                    <p class="badge bg-warning">¡Premium!</p>
                                </div>
                            </div>
                        </div>
                    </div><br>


                    <!-- TARJETAS NORMALES -->
                    <div class="row row-cols-1 row-cols-md-4 g-4">
                        <!-- 1 -->
                        <div class="col">
                            <div class="card shadow">
                                <img src="./ruta" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Modelo del Vehículo</h5>
                                    <p class="card-text"><strong>Marca del coche</strong></p>
                                    <p class="card-text text-success">45€/día</p>
                                </div>
                            </div>
                        </div>

                        <!-- 2 -->
                        <div class="col">
                            <div class="card shadow">
                                <img src="./ruta" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Modelo del Vehículo</h5>
                                    <p class="card-text"><strong>Marca del coche</strong></p>
                                    <p class="card-text text-success">45€/día</p>
                                </div>
                            </div>
                        </div>

                        <!-- 3 -->
                        <div class="col">
                            <div class="card shadow">
                                <img src="./ruta" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Modelo del Vehículo</h5>
                                    <p class="card-text"><strong>Marca del coche</strong></p>
                                    <p class="card-text text-success">45€/día</p>
                                </div>
                            </div>
                        </div>

                        <!-- 4 -->
                        <div class="col">
                            <div class="card shadow">
                                <img src="./ruta" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Modelo del Vehículo</h5>
                                    <p class="card-text"><strong>Marca del coche</strong></p>
                                    <p class="card-text text-success">45€/día</p>
                                </div>
                            </div>
                        </div>

                        <!-- 5 -->
                        <div class="col">
                            <div class="card shadow">
                                <img src="./ruta" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Modelo del Vehículo</h5>
                                    <p class="card-text"><strong>Marca del coche</strong></p>
                                    <p class="card-text text-success">45€/día</p>
                                </div>
                            </div>
                        </div>

                        <!-- 6 -->
                        <div class="col">
                            <div class="card shadow">
                                <img src="./ruta" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Modelo del Vehículo</h5>
                                    <p class="card-text"><strong>Marca del coche</strong></p>
                                    <p class="card-text text-success">45€/día</p>
                                </div>
                            </div>
                        </div>

                        <!-- 7 -->
                        <div class="col">
                            <div class="card shadow">
                                <img src="./ruta" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Modelo del Vehículo</h5>
                                    <p class="card-text"><strong>Marca del coche</strong></p>
                                    <p class="card-text text-success">45€/día</p>
                                </div>
                            </div>
                        </div>

                        <!-- 8 -->
                        <div class="col">
                            <div class="card shadow">
                                <img src="./ruta" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">Modelo del Vehículo</h5>
                                    <p class="card-text"><strong>Marca del coche</strong></p>
                                    <p class="card-text text-success">45€/día</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- fin tarjetas -->


        </div>
    </div>

    <!-- FOOTER -->
    <?php include_once 'src/components/footer.php'; ?>

    <!-- FUNCIONES -->
    <script>
        // DESPLEGABLE PARA VER EL EQUIPAMIENTO
        function Equipamiento() {
            const contenedor = document.getElementById("opciones-equipamiento");
            const flecha = document.getElementById("flecha");

            if (contenedor.style.display === "none" || contenedor.style.display === "") {
                contenedor.style.display = "block";
                flecha.classList.add("girada");
            } else {
                contenedor.style.display = "none";
                flecha.classList.remove("girada");
            }
        }
    </script>
</body>

</html>