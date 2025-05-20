<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="../../../src/styles/mostrar_coches.css">


    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    require(__DIR__ . "/../../config/conexion.php");

    session_start();
    ?>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">


    <!-- NAVBAR -->
    <?php include_once '../../components/navbar.php'; ?>

    <!-- BANNER (Hero) -->
    <div class="banner-video-container d-flex justify-content-center align-items-center text-center">
        <video autoplay muted loop playsinline class="banner-video">
            <source src="/src/video/socialicar_3.webm" type="video/mp4" />
        </video>
        <div class="banner-content text-white">
            <h1>Encuentra tu <i>vehiculo</i> ideal</h1>
            <h3>Alquila vehículos de forma segura</h3>
        </div>
    </div>

    <!-- BARRA DE BUSQUEDA -->
    <form class="w-75 mx-auto my-4 busqueda" method="POST" action="">
        <div class="input-group rounded-pill overflow-hidden shadow-sm">
            <input type="text" name="buscar" id="buscar" class="form-control border-0 py-2 px-3" placeholder="Buscar vehículo" value="<?php echo isset($_POST['buscar']) ? $_POST['buscar'] : ''; ?>">
            <button class="btn_buscar" type="submit">Buscar</button>
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


    <!-- Botón para desplegar menú (flotante) -->
    <button
        id="toggleFiltros"
        class="btn btn-warning rounded-circle shadow-sm position-fixed"
        style="right: 20px; top: 50%; transform: translateY(-50%); z-index: 1000;"
        data-bs-toggle="offcanvas"
        data-bs-target="#filtrosOffcanvas">
        <i class="fas fa-chevron-left"></i>
    </button>

    <!-- Menú de filtros  -->
    <div
        class="offcanvas offcanvas-end"
        tabindex="-1"
        id="filtrosOffcanvas"
        aria-labelledby="filtrosLabel"
        style="width: 500px;">
        <div class="offcanvas-header border-bottom">
            <h3 class="offcanvas-title" id="filtrosLabel">Filtros</h3>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>

        <div class="offcanvas-body pt-0">
            <!-- MARCA -->
            <div class="mt-3">
                <label class="form-label">Marca:</label>
                <select class="form-select">
                    <option selected>- - Selecciona una marca - -</option>
                    <option value="1">Alfa Romeo</option>
                    <option value="2">Volkswagen</option>
                    <option value="3">BMW</option>
                    <option value="4">Mercedes</option>
                    <option value="5">Nissan</option>
                </select>
            </div>

            <!-- MODELO -->
            <div class="mt-3">
                <label class="form-label">Modelo:</label>
                <select class="form-select">
                    <option selected>- - Selecciona un modelo - -</option>
                    <option value="1">Modelo</option>
                </select>
            </div>

            <!-- CIUDAD -->
            <div class="mt-3">
                <label class="form-label">Ubicación:</label>
                <select class="form-select">
                    <option selected>- - Selecciona una ciudad - -</option>
                    <option value="1">Málaga</option>
                    <option value="2">Granada</option>
                    <option value="3">Madrid</option>
                    <option value="4">Valencia</option>
                    <option value="5">Barcelona</option>
                </select>
            </div>

            <!-- TIPO -->
            <div class="mt-3">
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
            </div>

            <!-- COMBUSTIBLE -->
            <div class="mt-3">
                <label class="form-label">Combustible:</label>
                <select class="form-select">
                    <option selected>- - Selecciona un tipo - -</option>
                    <option value="Diésel">Diésel</option>
                    <option value="Gasolina">Gasolina</option>
                    <option value="Eléctrico">Eléctrico</option>
                    <option value="Híbrido">Híbrido</option>
                </select>
            </div>

            <!-- PRECIO -->
            <div class="mt-3">
                <label class="form-label">Precio Diario (€):</label>
                <input type="range" class="form-range" min="0" max="500" step="10">
                <div class="d-flex justify-content-between">
                    <span>€0</span>
                    <span>€500</span>
                </div>
            </div>

            <!-- FECHAS -->
            <div class="mt-3">
                <label class="form-label">Disponibilidad</label>
                <div class="d-flex gap-2">
                    <div class="flex-fill">
                        <label class="form-label">Inicio</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="flex-fill">
                        <label class="form-label">Fin</label>
                        <input type="date" class="form-control">
                    </div>
                </div>
            </div>

            
            <!-- OTROS FILTROS -->
            <div class="mt-3">
                <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#equipamientoCollapse">
                    <b>Equipamiento</b>
                    <i class="fas fa-chevron-down"></i>
                </div>

                <div class="collapse" id="equipamientoCollapse">
                    <!-- Checkboxes de equipamiento aquí -->
                    <div class="form-check">
                        <!-- OTROS FILTROS -->
                        <div class="modal-body">
                            <!-- Sección Características Básicas -->
                            <div>
                                <div>
                                    <h6>Características Básicas</h6>
                                </div>
                                <div>
                                    <div>
                                        <input type="checkbox" id="mascota" name="mascota" <?php if (isset($_POST['mascota'])) echo 'checked'; ?>>
                                        <label for="mascota">
                                            Permito mascotas
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="fumar" name="fumar" <?php if (isset($_POST['fumar'])) echo 'checked'; ?>>
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
                                        <input type="checkbox" id="gps" name="gps" <?php if (isset($_POST['gps'])) echo 'checked'; ?>>
                                        <label for="gps">
                                            GPS
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="sensores_aparcamiento" name="sensores_aparcamiento" <?php if (isset($_POST['sensores_aparcamiento'])) echo 'checked'; ?>>
                                        <label for="sensores_aparcamiento">
                                            Sensores de aparcamiento
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="camara_trasera" name="camara_trasera" <?php if (isset($_POST['camara_trasera'])) echo 'checked'; ?>>
                                        <label for="camara_trasera">
                                            Cámara de reversa
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="control_de_crucero" name="control_de_crucero" <?php if (isset($_POST['control_de_crucero'])) echo 'checked'; ?>>
                                        <label for="control_de_crucero">
                                            Control de crucero
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="cuatro_x_cuatro" name="cuatro_x_cuatro" <?php if (isset($_POST['cuatro_x_cuatro'])) echo 'checked'; ?>>
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
                                        <input type="checkbox" id="baca" name="baca" <?php if (isset($_POST['baca'])) echo 'checked'; ?>>
                                        <label for="baca">
                                            Baca
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="portabicicletas" name="portabicicletas" <?php if (isset($_POST['portabicicletas'])) echo 'checked'; ?>>
                                        <label for="portabicicletas">
                                            Portabicicletas
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="portaequipajes" name="portaequipajes" <?php if (isset($_POST['portaequipajes'])) echo 'checked'; ?>>
                                        <label for="portaequipajes">
                                            Portaequipajes
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="portaesquis" name="portaesquis" <?php if (isset($_POST['portaesquis'])) echo 'checked'; ?>>
                                        <label for="portaesquis">
                                            Portaesquís
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="bola_remolque" name="bola_remolque" <?php if (isset($_POST['bola_remolque'])) echo 'checked'; ?>>
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
                                        <input type="checkbox" id="bluetooth" name="bluetooth" <?php if (isset($_POST['bluetooth'])) echo 'checked'; ?>>
                                        <label for="bluetooth">
                                            Bluetooth
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="wifi" name="wifi" <?php if (isset($_POST['wifi'])) echo 'checked'; ?>>
                                        <label for="wifi">
                                            WiFi
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="android_carplay" name="android_carplay" <?php if (isset($_POST['android_carplay'])) echo 'checked'; ?>>
                                        <label for="android_carplay">
                                            Android CarPlay
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="apple_carplay" name="apple_carplay" <?php if (isset($_POST['apple_carplay'])) echo 'checked'; ?>>
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
                                        <input type="checkbox" id="aire_acondicionado" name="aire_acondicionado" <?php if (isset($_POST['aire_acondicionado'])) echo 'checked'; ?>>
                                        <label for="aire_acondicionado">
                                            Aire acondicionado
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="asientos_calefactables" name="asientos_calefactables" <?php if (isset($_POST['asientos_calefactables'])) echo 'checked'; ?>>
                                        <label for="asientos_calefactables">
                                            Asientos calefactables
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="fijacion_isofix" name="fijacion_isofix" <?php if (isset($_POST['fijacion_isofix'])) echo 'checked'; ?>>
                                        <label for="fijacion_isofix">
                                            Fijaciones ISOFIX
                                        </label>
                                    </div>
                                    <div>
                                        <input type="checkbox" id="movilidad_reducida" name="movilidad_reducida" <?php if (isset($_POST['movilidad_reducida'])) echo 'checked'; ?>>
                                        <label for="movilidad_reducida">
                                            Adaptado para personas con movilidad reducida
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- ... resto de checkboxes ... -->
            </div>
        </div>

        <!-- BOTONES FINALES -->
        <div class="mt-4 d-grid gap-2">
            <button class="btn btn-primary" type="button">Aplicar Filtros</button>
            <button class="btn btn-warning" type="submit">Buscar</button>
        </div>
    </div>
    </div>

    <!-- Script para rotar el ícono del botón -->
    <script>
        document.getElementById('filtrosOffcanvas').addEventListener('show.bs.offcanvas', function() {
            document.querySelector('#toggleFiltros i').classList.replace('fa-chevron-left', 'fa-chevron-right');
        });

        document.getElementById('filtrosOffcanvas').addEventListener('hide.bs.offcanvas', function() {
            document.querySelector('#toggleFiltros i').classList.replace('fa-chevron-right', 'fa-chevron-left');
        });
    </script>
    <?php
    $provincia = isset($_GET['provincia']) ? $_GET['provincia'] : null;
    $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
    $fecha_fin = isset($_GET['fecha_final']) ? $_GET['fecha_final'] : null;
    $checkear_coches = true;

    if ($provincia != null && $fecha_inicio != null && $fecha_fin != null) { ?>
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
                                WHERE coche.provincia = ?
                                AND NOT EXISTS (
                                    SELECT 1 FROM reserva_coche 
                                    WHERE reserva_coche.matricula = coche.matricula 
                                    AND (
                                        (? BETWEEN reserva_coche.fecha_inicio AND reserva_coche.fecha_final) OR
                                        (? BETWEEN reserva_coche.fecha_inicio AND reserva_coche.fecha_final) OR
                                        (reserva_coche.fecha_inicio BETWEEN ? AND ?) OR
                                        (reserva_coche.fecha_final BETWEEN ? AND ?)
                                    )
                                )
                                ORDER BY coche.precio ASC
                                LIMIT 3
                            ");
                    $obtener_coche_premium->bind_param("sssssss", $provincia, $fecha_inicio, $fecha_fin, $fecha_inicio, $fecha_fin, $fecha_inicio, $fecha_fin);
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
                    } else {
                        $checkear_coches = false;
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
                                WHERE coche.provincia = ?
                                AND NOT EXISTS (
                                    SELECT 1 FROM reserva_coche 
                                    WHERE reserva_coche.matricula = coche.matricula 
                                    AND (
                                        (? BETWEEN reserva_coche.fecha_inicio AND reserva_coche.fecha_final) OR
                                        (? BETWEEN reserva_coche.fecha_inicio AND reserva_coche.fecha_final) OR
                                        (reserva_coche.fecha_inicio BETWEEN ? AND ?) OR
                                        (reserva_coche.fecha_final BETWEEN ? AND ?)
                                    )
                                )
                                ORDER BY coche.precio ASC
                                LIMIT 6
                            ");
                    $obtener_coche_plus->bind_param("sssssss", $provincia, $fecha_inicio, $fecha_fin, $fecha_inicio, $fecha_fin, $fecha_inicio, $fecha_fin);
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
                    } else {
                        $checkear_coches = false;
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
                                AND coche.provincia = ?
                                AND NOT EXISTS (
                                    SELECT 1 FROM reserva_coche 
                                    WHERE reserva_coche.matricula = coche.matricula 
                                    AND (
                                        (? BETWEEN reserva_coche.fecha_inicio AND reserva_coche.fecha_final) OR
                                        (? BETWEEN reserva_coche.fecha_inicio AND reserva_coche.fecha_final) OR
                                        (reserva_coche.fecha_inicio BETWEEN ? AND ?) OR
                                        (reserva_coche.fecha_final BETWEEN ? AND ?)
                                    )
                                )
                                LIMIT 6
                            ");
                    $obtener_coche_normal->bind_param("sssssss", $provincia, $fecha_inicio, $fecha_fin, $fecha_inicio, $fecha_fin, $fecha_inicio, $fecha_fin);
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
                    } else {
                        $checkear_coches = false;
                    }

                    if ($checkear_coches == false) { ?>
                        <div>
                            <h1>No hay coches disponibles</h1>
                        </div>
                    <?php } ?>
                </div><br>
            </div>
        </div>
    <?php } else {
    ?>
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
    <?php } ?>
    </div>
    </div>

    <!-- FOOTER -->
    <?php include_once '../../components/footer-example.php'; ?>

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