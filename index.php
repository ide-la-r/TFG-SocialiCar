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

    /* BANNER */
    .banner-video-container {
        position: relative;
        height: 70vh;
        overflow: hidden;
        z-index: 0;
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

    /* MENU DE FILTROS*/
    .menu-de-filtros {
        width: 25%;
        /* Un pequeño incremento sobre el 16.6% de 2 columnas */
    }

    /* BARRA DE BUSQUEDA */
    .busqueda {
        position: absolute;
        top: 65%;
        left: 50%;
        transform: translateX(-50%);
        z-index: 3;
        width: 70%;
        margin-top: 0;
    }

    /* Animación de los títulos */
    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .banner-content h1 {
        font-size: 3.5rem;
        animation: fadeInUp 1s ease-out forwards;
        opacity: 0;
    }

    .banner-content h3 {
        animation: fadeInUp 1.2s ease-out forwards;
        opacity: 0;
    }

    .banner-content h3 {
        animation-delay: 0.7s;
    }


    /* video inicial*/
    #video {
        width: 100%;
        height: 100vh;
        object-fit: cover;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 4;
        animation: difuminarVideo 3.9s forwards;
    }

    #contenido {
        position: relative;
        width: 100%;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        opacity: 1;
        z-index: 20;
        background: none;
    }

    /* difuminar el video */
    @keyframes difuminarVideo {
        0% {
            opacity: 1;
            filter: blur(0px);
        }

        100% {
            opacity: 0;
            filter: blur(5px);
        }
    }

    /* CARTAS DE LOS COCHES */
    .card {
        position: relative;
        transition: transform 0.3s ease;
    }


    .card:hover {
        transform: scale(1.05);
        cursor: pointer;
    }

    .card-img-premium {
        height: 40vh;
        object-fit: cover;
        width: 100%;
    }

    .card-img-top {
        height: 20vh;
        object-fit: cover;
        width: 100%;
    }


    
</style>

<body class="d-flex flex-column min-vh-100">

    <video id="video" autoplay muted playsinline>
        <source src="/socialicar/src/video/socialicar_2.mp4" type="video/mp4">
        Tu navegador no soporta el formato de video.
    </video>
    <script>
        document.getElementById('video').playbackRate = 2; // se reproduce a x2
    </script>


    <!-- NAVBAR -->
    <?php include_once 'src/components/navbar.php'; ?>

    <!-- BANNER (Hero) -->
    <div class="banner-video-container d-flex justify-content-center align-items-center text-center">
        <video autoplay muted loop playsinline class="banner-video">
            <source src="/socialicar/src/video/socialicar_3.mp4" type="video/mp4" />
        </video>
        <div class="banner-content text-white">
            <h1>Encuentra tu <i>vehiculo</i> ideal</h1>
            <h3>Alquila vehículos de forma segura</h3>
        </div>
    </div>

    <!-- BARRA DE BUSQUEDA -->
    <form class="w-75 mx-auto busqueda">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="buscar vehiculo">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>
    <br><br>



    <!-- MENU DE FILTROS DEL COCHE -->
    <div class="container-fluid" style="margin-top: -6vh; padding-left: 4vh; padding-bottom: 1vh">
        <div class="row">
            <div class="col-md-2 menu-de-filtros border-top border-end border-bottom pe-3">
            <div class="col-md-1">
        </div>

        
                <h3 style="margin-top: 3vh;">Filtros</h3>
                <!-- MARCA -->
                <div>
                    <label class="form-label"><b>Marca:</b></label>
                    <select class="form-select">
                        <option selected>- - Selecciona una marca - -</option>
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
                    <label class="form-label"><b>Modelo:</b></label>
                    <select class="form-select">
                        <option selected>- - Selecciona un modelo - -</option>
                        <option value="1">Modelo</option>
                        <!-- API coches para modelos QUE CAMBIARAN SEGUN LA MARCA-->
                    </select>
                </div><br>

                <!-- CIUDAD -->
                <div>
                    <label for="ciudad" class="form-label"><b>Ubicación:</b></label>
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
                        <option selected>- - Selecciona un tipo de coche - -</option>
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

                <!-- PRECIO   poner para escribir y que se ajuste en la barra-->
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
                <div style="padding-bottom: 1vh;">
                    <button class="btn btn-primary" type="button">Aplicar Filtros</button>
                    <button class="btn btn-warning" type="submit">Buscar</button>
                </div>
            </div> <!-- fin del menu -->


            <!-- TARJETAS DE LOS USUARIOS PREMIUM -->
            <div class="col-md-9 bg-light">
                <div class="container my-4">
                    <!-- TARJETAS -->
                    <!-- tarjetas premium -->
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <!-- 1 -->
                        <div class="col">
                            <div class="card h-100 shadow-lg border-success">
                                <img src="https://cdn.classic-trader.com/I/images/1920_1920_inset/vehicle_ad_standard_image_0829ce87a13d4a47d162eba1e504d203.jpg"
                                    class="card-img-premium">
                                <div class="card-body">
                                    <h5 class="card-title">Mercedes AMG GT</h5>
                                    <p class="card-text"><strong>Porsche</strong></p>
                                    <p class="card-text text-success">450€/día</p>
                                    <p class="badge bg-warning">¡Premium!</p>
                                </div>
                            </div>
                        </div>

                        <!-- 2 -->
                        <div class="col">
                            <div class="card h-100 shadow-lg border-success">
                                <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-1.2.1&w=1200&fit=crop"
                                    class="card-img-premium">
                                <div class="card-body">
                                    <h5 class="card-title">Rolls-Royce Cullinan Black Badge</h5>
                                    <p class="card-text"><strong>Rolls-Royce</strong></p>
                                    <p class="card-text text-success">500€/día</p>
                                    <p class="badge bg-warning">¡Edición Limitada!</p>
                                </div>
                            </div>
                        </div>

                        <!-- 3 -->
                        <div class="col">
                            <div class="card h-100 shadow-lg border-success">
                                <img src="https://media.revistagq.com/photos/5f9855f07828529cb9a7a5e8/16:9/w_2560%2Cc_limit/porsche%2520panamera%25201.jpg" class="card-img-premium">
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
                                <img src="https://cdn.motor1.com/images/mgl/Kkqpq/s1/vw-polo-gti-by-siemoneit-racing.jpg" class="card-img-top">
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
                                <img src="https://i.pinimg.com/736x/71/e2/4b/71e24beb4b6dbcb35c2231711e4dcf31.jpg" class="card-img-top">
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
                                <img src="https://www.automoli.com/common/vehicles/_assets/img/gallery/f53/nissan-sentra-b15.jpg" class="card-img-top">
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
                                <img src="https://images.unsplash.com/photo-1555215695-3004980ad54e?ixlib=rb-1.2.1&w=1200" class="card-img-top">
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
                                <img src="https://cdn.blendio.es/bitool/vehicle/images/1200/900/20791/70cb09a658.jpg" class="card-img-top">
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
                                <img src="https://www.hyundai.com/es/es/modelos/i30-fastback.thumb.800.480.png?ck=1743677668" class="card-img-top">
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
                                <img src="https://images.coches.com/_vn_/ford/Ranger/47576f644b7aa090f109c67b66fdbc51.jpg?w=1920&ar=16:9" class="card-img-top">
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
                                <img src="https://avolo.net/wp-content/uploads/2024/12/dacia-duster-gasolina-2018-segunda-mano-8219-ad7483350c.webp" class="card-img-top">
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


    <script>
        //  VIDEO AL BUSCAR LA PAGINA
        // reproducir el video
        const video = document.getElementById('video');

        video.play().catch(error => {
            console.log("Error al intentar reproducir el video de inivio", error);
        });

        video.onended = function() {
            document.getElementById('video').style.display = 'none';
            document.getElementById('contenido').style.display = 'block';
        };

        // controlar si se ha visto o no
        document.addEventListener("DOMContentLoaded", function() {
            const yaVisto = sessionStorage.getItem('videoVisto');

            if (yaVisto) { // si se ha visto el video no sale mas
                const video = document.getElementById('video');
                if (video) {
                    video.parentNode.removeChild(video);
                }
            } else { // cuando cargue la pagina decimos que se ha visto
                sessionStorage.setItem('videoVisto', 'true');
            }
        });
    </script>

</body>

</html>