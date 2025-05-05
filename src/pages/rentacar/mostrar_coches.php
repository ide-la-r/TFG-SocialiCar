<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="../../../src/styles/index.css">

    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    require(__DIR__ . "/../../config/conexion.php");

    session_start();
    ?>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

    <video id="video" autoplay muted playsinline>
        <source src="/src/video/socialicar_2.mp4" type="video/mp4">
        Tu navegador no soporta el formato de video.
    </video>
    <script>
        document.getElementById('video').playbackRate = 2; // se reproduce a x2
    </script>


    <!-- NAVBAR -->
    <?php include_once '../../components/navbar.php'; ?>

    <!-- BANNER (Hero) -->
    <div class="banner-video-container d-flex justify-content-center align-items-center text-center">
        <video autoplay muted loop playsinline class="banner-video">
            <source src="/src/video/socialicar_3.mp4" type="video/mp4" />
        </video>
        <div class="banner-content text-white">
            <h1>Encuentra tu <i>vehiculo</i> ideal</h1>
            <h3>Alquila vehículos de forma segura</h3>
        </div>
    </div>

    <!-- BARRA DE BUSQUEDA -->
    <form class="w-75 mx-auto busqueda" method="POST" action="">
        <div class="input-group">
            <input type="text" name="buscar" id="buscar" class="form-control" placeholder="Buscar vehículo" value="<?php echo isset($_POST['buscar']) ? $_POST['buscar'] : ''; ?>">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>
    <br><br>
    <?php
        if (isset($_POST["buscar"])) {
            $buscar = mysqli_real_escape_string($_conexion, $_POST["buscar"]);

            $sql = mysqli_query($_conexion, "SELECT * FROM coche 
                WHERE 
                    precio LIKE '%$buscar%' OR
                    marca LIKE '%$buscar%' OR 
                    modelo LIKE '%$buscar%' OR 
                    ciudad LIKE '%$buscar%' OR 
                    codigo_postal LIKE '%$buscar%' OR 
                    color LIKE '%$buscar%' OR
                    descripcion LIKE '%$buscar%' OR
                    combustible LIKE '%$buscar%' OR
                    transmision LIKE '%$buscar%' OR
                    provincia LIKE '%$buscar%' OR
                    tipo_aparcamiento LIKE '%$buscar%'");

            $numeroSql = mysqli_num_rows($sql);

            echo "<p class='text-success fw-bold mt-3'>
                <i class='mdi mdi-car-search'></i> $numeroSql resultados encontrados
            </p>";

            echo "<div class='row row-cols-1 row-cols-md-3 g-4 mt-3'>";

            while ($row = mysqli_fetch_assoc($sql)) {
                echo "
                    <div class='col'>
                        <a href='/src/pages/rentacar/coche?matricula=" . $row['matricula'] . "' class='text-decoration-none text-dark'>
                            <div class='card h-100 shadow-sm border-primary'>
                                <img src='" . htmlspecialchars($row['ruta_img_coche']) . "' class='card-img-top' alt='Imagen del coche'>
                                <div class='card-body'>
                                    <h5 class='card-title'>" . htmlspecialchars($row['marca']) . " " . htmlspecialchars($row['modelo']) . "</h5>
                                    <p class='card-text'><strong>" . htmlspecialchars($row['marca']) . "</strong></p>
                                    <p class='card-text'><strong>" . htmlspecialchars($row['codigo_postal']) . " " . htmlspecialchars($row['ciudad']) . "</strong></p>
                                    <p class='card-text text-success'>" . htmlspecialchars($row['precio']) . "€/día</p>
                                </div>
                            </div>
                        </a>
                    </div>
                ";
            }

            echo "</div><br>";
        }
    ?>



    <!-- MENU DE FILTROS DEL COCHE -->
    <div class="container-fluid menu" style="margin-top: -6vh; padding-bottom: 1vh">
        <div class="row">
            <div class="col-md-2 menu-de-filtros border-top border-end border-bottom pe-3">
                <div class="col-md-1">
                </div>


                <!-- BOTON PARA OCULTAR MENU -->
                <div class="d-flex align-items-center justify-content-between">
                    <button id="toggleFiltros" class="btn btn-warning rounded-circle shadow-sm">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>
                <div class="contenido-filtros">
                    <h3 class="mb-0" style="margin-top: 3vh;">Filtros</h3>
                    <!-- MARCA -->
                    <div>
                        <label class="form-label">Marca:</label>
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
                        <label class="form-label">Modelo:</label>
                        <select class="form-select">
                            <option selected>- - Selecciona un modelo - -</option>
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
                </div>


            </div> <!-- fin del menu -->


            <div class="col-md-9 bg-light">
                <div class="container my-4 ">
                    <!-- TARJETAS -->
                    <!-- Tarjetas Premium -->
                    <div class="row row-cols-1 row-cols-md-3 g-4 ">
                        <?php
                            $obtener_coche_premium = $_conexion->prepare("
                                SELECT coche.*, sus.tipo AS tipo_suscripcion
                                FROM coche
                                JOIN usuario ON coche.id_usuario = usuario.identificacion
                                JOIN suscripcion_usuario sus 
                                    ON sus.identificacion = usuario.identificacion 
                                    AND sus.activo = TRUE 
                                    AND sus.tipo = 'Premium'
                                ORDER BY coche.precio ASC
                                LIMIT 3
                            ");
                            $obtener_coche_premium->execute();
                            $resultado = $obtener_coche_premium->get_result();
                            $vehiculos_premiums = $resultado->fetch_all(MYSQLI_ASSOC);
                            
                            if (count($vehiculos_premiums) > 0) {
                                foreach ($vehiculos_premiums as $vehiculo_premium) {
                                    echo "
                                        <div class='col'>
                                            <a href='/src/pages/rentacar/coche?matricula=" . $vehiculo_premium['matricula'] . "' class='text-decoration-none text-dark'>
                                            <div class='card h-100 shadow-lg border-warning'>
                                                <img src='" . $vehiculo_premium['ruta_img_coche'] . "' class='card-img-top'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>" . $vehiculo_premium['marca'] . " " . $vehiculo_premium['modelo'] . "</h5>
                                                    <p class='card-text'><strong>" . $vehiculo_premium['marca'] . "</strong></p>
                                                    <p class='card-text'><strong>" . $vehiculo_premium['codigo_postal'] . " " . $vehiculo_premium['ciudad'] . "</strong></p>
                                                    <p class='card-text text-success'>" . $vehiculo_premium['precio'] . "€/día</p>
                                                    <p class='badge bg-warning'>¡Premium!</p>
                                                </div>
                                            </div>
                                            </a>
                                        </div>
                                    ";
                                }
                            }
                        ?>
                    </div><br>


                    <!-- Tarjetas Plus -->
                    <div class="row row-cols-1 row-cols-md-3 g-4 ">
                        <?php
                            $obtener_coche_plus = $_conexion->prepare("
                                SELECT coche.*, sus.tipo AS tipo_suscripcion
                                FROM coche
                                JOIN usuario ON coche.id_usuario = usuario.identificacion
                                JOIN suscripcion_usuario sus 
                                    ON sus.identificacion = usuario.identificacion 
                                    AND sus.activo = TRUE 
                                    AND sus.tipo = 'Plus'
                                ORDER BY coche.precio ASC
                                LIMIT 6
                            ");
                            $obtener_coche_plus->execute();
                            $resultado = $obtener_coche_plus->get_result();
                            $vehiculos_plus = $resultado->fetch_all(MYSQLI_ASSOC);
                            
                            if (count($vehiculos_plus) > 0) {
                                foreach ($vehiculos_plus as $vehiculo_plus) {
                                    echo "
                                        <div class='col'>
                                            <a href='/src/pages/rentacar/coche?matricula=" . $vehiculo_plus['matricula'] . "' class='text-decoration-none text-dark'>
                                            <div class='card shadow'>
                                                <img src='" . $vehiculo_plus['ruta_img_coche'] . "' class='card-img-top'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>" . $vehiculo_plus['marca'] . "</h5>
                                                    <p class='card-text'><strong>" . $vehiculo_plus['modelo'] . "</strong></p>
                                                    <p class='card-text'><strong>" . $vehiculo_plus['codigo_postal'] . " " . $vehiculo_plus['ciudad'] . "</strong></p>
                                                    <p class='card-text text-success'>" . $vehiculo_plus['precio'] . "€/día</p>
                                                </div>
                                            </div>
                                            </a>
                                        </div>
                                    ";
                                }
                            }
                        ?>
                    </div><br>


                    <!-- Tarjetas Normales -->
                    <div class="row row-cols-1 row-cols-md-3 g-4 ">
                        <?php
                            $obtener_coche_normal = $_conexion->prepare("
                                SELECT coche.*, sus.tipo AS tipo_suscripcion
                                FROM coche
                                JOIN usuario ON coche.id_usuario = usuario.identificacion
                                LEFT JOIN suscripcion_usuario sus 
                                    ON sus.identificacion = usuario.identificacion 
                                    AND sus.activo = TRUE
                                WHERE sus.tipo IS NULL
                                LIMIT 6
                            ");
                            $obtener_coche_normal->execute();
                            $resultado = $obtener_coche_normal->get_result();
                            $vehiculos_normales = $resultado->fetch_all(MYSQLI_ASSOC);

                            if (count($vehiculos_normales) > 0) {
                                foreach ($vehiculos_normales as $vehiculo_normal) {

                                    // Consulta para obtener la primera imagen del coche
                                    $obtener_primera_imagen = $_conexion->prepare("
                                        SELECT ruta_img_coche
                                        FROM imagen_coche
                                        WHERE id_coche = ?
                                        LIMIT 1
                                    ");
                                    $obtener_primera_imagen->bind_param("s", $vehiculo_normal['matricula']);
                                    $obtener_primera_imagen->execute();
                                    $resultado_imagen = $obtener_primera_imagen->get_result();

                                    // Verificar si se encontró una imagen
                                    if ($resultado_imagen->num_rows > 0) {
                                        $imagen_normal = $resultado_imagen->fetch_assoc();
                                        $imagen_normal = $imagen_normal['ruta_img_coche'];
                                    } else {
                                        $imagen_normal = 'ruta/por/defecto.jpg'; // Imagen por defecto si no se encuentra
                                    }

                                    echo "
                                        <div class='col'>
                                            <a href='/src/pages/rentacar/coche?matricula=" . $vehiculo_normal['matricula'] . "' class='text-decoration-none text-dark'>
                                            <div class='card shadow'>
                                                <img src='" . $imagen_normal . "' class='card-img-top'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>" . $vehiculo_normal['marca'] . "</h5>
                                                    <p class='card-text'><strong>" . $vehiculo_normal['modelo'] . "</strong></p>
                                                    <p class='card-text'><strong>" . $vehiculo_normal['codigo_postal'] . " " . $vehiculo_normal['ciudad'] . "</strong></p>
                                                    <p class='card-text text-success'>" . $vehiculo_normal['precio'] . "€/día</p>
                                                </div>
                                            </div>
                                            </a>
                                        </div>
                                    ";
                                }
                            }
                        ?>
                    </div><br>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php include_once '../../components/footer.php'; ?>

    <!-- FUNCIONES -->
    <script>
        // 1. DESPLEGABLE PARA VER EL EQUIPAMIENTO
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


        //  2. VIDEO AL BUSCAR LA PAGINA
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


        // 3. CAMBIAR CLASE PARA OCULTAR EL MENU
        document.getElementById('toggleFiltros').addEventListener('click', function() {
            const menu = document.querySelector('.menu-de-filtros');
            const icono = this.querySelector('i');

            menu.classList.toggle('menu-colapsado');
            icono.classList.toggle('fa-chevron-left');
            icono.classList.toggle('fa-chevron-right');
        });
    </script>

</body>

</html>