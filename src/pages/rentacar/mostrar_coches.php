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

<style>
    body {
        background-image: url('../../img/fondo_amarillo.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    #offcanvas-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 1040;
        display: none;
    }



    .tarjeta {
        width: 400px;
        margin: 10px;
        flex: 0 0 auto;
    }

    @media (max-width: 1400px) {
  .tarjeta {
    width: calc(50% - 20px);
  }
}


@media (max-width: 768px) {
  .tarjeta {
    width: calc(100% - 20px);
  }
}


    .card-img-top {
        height: 230px;
    }

    .card-title {
        font-size: 2rem;
    }

</style>

<body class="d-flex flex-column min-vh-100">


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

    <br><br>
    <?php
    // FILTRO AVANZADO
// FILTRO FUNCIONAL SOLO CON: marca, provincia, tipo, combustible, precio
if ($_SERVER['REQUEST_METHOD'] === 'GET' && (
    isset($_GET['marca']) || isset($_GET['ciudad']) ||
    isset($_GET['tipo']) || isset($_GET['combustible']) || isset($_GET['precio'])
)) {
    $where = [];
    $params = [];
    $types = '';

    if (!empty($_GET['marca'])) {
        $where[] = 'LOWER(marca) = ?';
        $params[] = mb_strtolower($_GET['marca'], 'UTF-8');
        $types .= 's';
    }
    if (!empty($_GET['ciudad'])) {
        $where[] = 'LOWER(provincia) = ?';
        $params[] = mb_strtolower($_GET['ciudad'], 'UTF-8');
        $types .= 's';
    }
    if (!empty($_GET['tipo'])) {
        $where[] = 'LOWER(tipo) = ?';
        $params[] = mb_strtolower($_GET['tipo'], 'UTF-8');
        $types .= 's';
    }
    if (!empty($_GET['combustible'])) {
        $where[] = 'LOWER(combustible) = ?';
        $params[] = mb_strtolower($_GET['combustible'], 'UTF-8');
        $types .= 's';
    }
    if (isset($_GET['precio']) && $_GET['precio'] !== '') {
        $where[] = 'precio <= ?';
        $params[] = intval($_GET['precio']);
        $types .= 'i';
    }

    $sql = "SELECT * FROM coche";
    if (count($where) > 0) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }
    $sql .= " ORDER BY precio ASC";

    $stmt = $_conexion->prepare($sql);
    if ($types && $params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $num = $result->num_rows;
    // Visual badge for resultados encontrados
    echo "<div class='d-flex align-items-center justify-content-center my-4'>
            <span class='badge bg-primary fs-4 px-4 py-3 shadow-lg'>
                <i class='mdi mdi-car-search me-2'></i>
                <span class='fw-bold'>$num</span> " . ($num == 1 ? "resultado encontrado" : "resultados encontrados") . "
            </span>
        </div>";

    echo "<div class='row row-cols-1 row-cols-md-3 g-4 mt-3'>";
    while ($row = $result->fetch_assoc()) {
        // Obtener la imagen principal del coche
        $img = $row['ruta_img_coche'];
        if (empty($img)) {
            $stmtImg = $_conexion->prepare("SELECT ruta_img_coche FROM imagen_coche WHERE id_coche = ? ORDER BY orden ASC, id_imagen_coche ASC LIMIT 1");
            $stmtImg->bind_param("s", $row['matricula']);
            $stmtImg->execute();
            $resImg = $stmtImg->get_result();
            if ($imgRow = $resImg->fetch_assoc()) {
                $img = $imgRow['ruta_img_coche'];
            } else {
                $img = '/src/img/default-car.jpg';
            }
            $stmtImg->close();
        }
        echo "
            <div class='tarjeta row g-4'>
                <a href='/src/pages/rentacar/coche?matricula=" . htmlspecialchars($row['matricula']) . "' class='text-decoration-none text-dark'>
                    <div class='dentro-tarjeta card h-100 shadow-sm border-primary'>
                        <img src='" . htmlspecialchars($img) . "' class='card-img-top' alt='Imagen del coche' style='object-fit:cover; width:100%; height:230px;'>
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
    $stmt->close();
} else if (isset($_POST["buscar"])) {
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
    <form method="get" action="" id="form-filtros">
    <div
        class="offcanvas offcanvas-end p-4"
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
                <select class="form-select" name="marca" id="marca-filtro">
                    <option value="">- - Selecciona una marca - -</option>
                    <!-- Opciones de marca se rellenan por JS -->
                </select>
            </div>

            <!-- PROVINCIA -->
            <div class="mt-3">
                <label class="form-label">Ubicación:</label>
                <select class="form-select" name="ciudad">
                    <option value="">- - Selecciona una ciudad - -</option>
                    <option value="malaga" <?php if(isset($_GET['ciudad']) && $_GET['ciudad']=='malaga') echo 'selected'; ?>>Málaga</option>
                    <option value="granada" <?php if(isset($_GET['ciudad']) && $_GET['ciudad']=='granada') echo 'selected'; ?>>Granada</option>
                    <option value="madrid" <?php if(isset($_GET['ciudad']) && $_GET['ciudad']=='madrid') echo 'selected'; ?>>Madrid</option>
                    <option value="valencia" <?php if(isset($_GET['ciudad']) && $_GET['ciudad']=='valencia') echo 'selected'; ?>>Valencia</option>
                    <option value="barcelona" <?php if(isset($_GET['ciudad']) && $_GET['ciudad']=='barcelona') echo 'selected'; ?>>Barcelona</option>
                </select>
            </div>

            <!-- TIPO -->
            <div class="mt-3">
                <label class="form-label">Tipo de Coche:</label>
                <select class="form-select" name="tipo">
                    <option value="">- - Selecciona un tipo de coche - -</option>
                    <option value="berlina" <?php if(isset($_GET['tipo']) && $_GET['tipo']=='berlina') echo 'selected'; ?>>Berlina</option>
                    <option value="coupé" <?php if(isset($_GET['tipo']) && $_GET['tipo']=='coupé') echo 'selected'; ?>>Coupé</option>
                    <option value="monovolumen" <?php if(isset($_GET['tipo']) && $_GET['tipo']=='monovolumen') echo 'selected'; ?>>Monovolumen</option>
                    <option value="suv" <?php if(isset($_GET['tipo']) && $_GET['tipo']=='suv') echo 'selected'; ?>>SUV</option>
                    <option value="familiar" <?php if(isset($_GET['tipo']) && $_GET['tipo']=='familiar') echo 'selected'; ?>>Familiar</option>
                    <option value="furgoneta" <?php if(isset($_GET['tipo']) && $_GET['tipo']=='furgoneta') echo 'selected'; ?>>Furgoneta</option>
                    <option value="utilitario" <?php if(isset($_GET['tipo']) && $_GET['tipo']=='utilitario') echo 'selected'; ?>>Utilitario</option>
                    <option value="autocaravana" <?php if(isset($_GET['tipo']) && $_GET['tipo']=='autocaravana') echo 'selected'; ?>>Autocaravana</option>
                </select>
            </div>

            <!-- COMBUSTIBLE -->
            <div class="mt-3">
                <label class="form-label">Combustible:</label>
                <select class="form-select" name="combustible">
                    <option value="">- - Selecciona un tipo - -</option>
                    <option value="diesel" <?php if(isset($_GET['combustible']) && $_GET['combustible']=='diesel') echo 'selected'; ?>>Diésel</option>
                    <option value="gasolina" <?php if(isset($_GET['combustible']) && $_GET['combustible']=='gasolina') echo 'selected'; ?>>Gasolina</option>
                    <option value="electrico" <?php if(isset($_GET['combustible']) && $_GET['combustible']=='electrico') echo 'selected'; ?>>Eléctrico</option>
                    <option value="hibrido" <?php if(isset($_GET['combustible']) && $_GET['combustible']=='hibrido') echo 'selected'; ?>>Híbrido</option>
                </select>
            </div>

            <!-- PRECIO -->
            <div class="mt-3">
                <label class="form-label">Precio Diario (€):</label>
                <input type="range" class="form-range" min="0" max="500" step="1" name="precio" id="precioRange" value="<?php echo isset($_GET['precio']) ? intval($_GET['precio']) : 500; ?>">
                <div class="d-flex justify-content-between">
                    <span>0€</span>
                    <span id="precioValue"><?php echo isset($_GET['precio']) ? intval($_GET['precio']) : 500; ?>€</span>
                </div>
            </div>

            <!-- BOTONES FINALES -->
            <div class="mt-4 d-grid gap-2">
                <button class="btn btn-primary" type="submit">Aplicar Filtros</button>
            </div>
        </div>
    </div>
    </form>

    <script>
    // Mostrar el valor del rango de precio
    const precioRange = document.getElementById('precioRange');
    const precioValue = document.getElementById('precioValue');
    if(precioRange && precioValue) {
        precioRange.addEventListener('input', function() {
            precioValue.textContent = this.value + "€";
        });
    }

    // Cargar marcas desde la API
    document.addEventListener('DOMContentLoaded', function () {
        const marcaSelect = document.getElementById('marca-filtro');
        // El select de modelo ya no existe, así que no lo buscamos ni lo usamos

        // Cargar marcas desde la API
        fetch('https://vpic.nhtsa.dot.gov/api/vehicles/GetMakesForVehicleType/car?format=json')
            .then(res => res.json())
            .then(data => {
                let marcas = data.Results || [];
                marcas.sort((a, b) => a.MakeName.localeCompare(b.MakeName));
                let marcaSeleccionada = "<?php echo isset($_GET['marca']) ? addslashes($_GET['marca']) : ''; ?>";
                marcas.forEach(function (marca) {
                    const option = document.createElement('option');
                    option.value = marca.MakeName;
                    option.textContent = marca.MakeName;
                    if (marcaSeleccionada && marcaSeleccionada === marca.MakeName) {
                        option.selected = true;
                    }
                    marcaSelect.appendChild(option);
                });
            })
            .catch(error => {});
    });
    </script>

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
    $checkear_coches = false;


    if ($provincia !== null) {
        $provincia = mb_strtolower($provincia, 'UTF-8');
    }

    if ($provincia != null && $fecha_inicio != null && $fecha_fin != null) { ?>
        <div class="col-12">
            <div class="container my-4">
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
                                WHERE LOWER(coche.provincia) = ?
                                AND NOT EXISTS (
                                    SELECT 1 FROM reserva_coche 
                                    WHERE reserva_coche.matricula = coche.matricula 
                                    AND (
                                        (DATE(?) BETWEEN DATE(reserva_coche.fecha_inicio) AND DATE(reserva_coche.fecha_final)) OR
                                        (DATE(?) BETWEEN DATE(reserva_coche.fecha_inicio) AND DATE(reserva_coche.fecha_final)) OR
                                        (DATE(reserva_coche.fecha_inicio) BETWEEN DATE(?) AND DATE(?)) OR
                                        (DATE(reserva_coche.fecha_final) BETWEEN DATE(?) AND DATE(?))
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
                                        <div class='tarjeta row g-4'>
                                            <a href='/src/pages/rentacar/coche?matricula=" . $vehiculo_premium['matricula'] . "' class='text-decoration-none text-dark'>
                                            <div class='dentro-tarjeta card h-100 shadow-lg border-warning'>
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
                        $checkear_coches = true;
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
                                WHERE LOWER(coche.provincia) = ?
                                AND NOT EXISTS (
                                    SELECT 1 FROM reserva_coche 
                                    WHERE reserva_coche.matricula = coche.matricula 
                                    AND (
                                        (DATE(?) BETWEEN DATE(reserva_coche.fecha_inicio) AND DATE(reserva_coche.fecha_final)) OR
                                        (DATE(?) BETWEEN DATE(reserva_coche.fecha_inicio) AND DATE(reserva_coche.fecha_final)) OR
                                        (DATE(reserva_coche.fecha_inicio) BETWEEN DATE(?) AND DATE(?)) OR
                                        (DATE(reserva_coche.fecha_final) BETWEEN DATE(?) AND DATE(?))
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
                                        <div class='tarjeta row g-4'>
                                            <a href='/src/pages/rentacar/coche?matricula=" . $vehiculo_plus['matricula'] . "' class='text-decoration-none text-dark'>
                                            <div class='dentro-tarjeta card shadow'>
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
                        $checkear_coches = true;
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
                                AND LOWER(coche.provincia) = ?
                                AND NOT EXISTS (
                                    SELECT 1 FROM reserva_coche 
                                    WHERE reserva_coche.matricula = coche.matricula 
                                    AND (
                                        (DATE(?) BETWEEN DATE(reserva_coche.fecha_inicio) AND DATE(reserva_coche.fecha_final)) OR
                                        (DATE(?) BETWEEN DATE(reserva_coche.fecha_inicio) AND DATE(reserva_coche.fecha_final)) OR
                                        (DATE(reserva_coche.fecha_inicio) BETWEEN DATE(?) AND DATE(?)) OR
                                        (DATE(reserva_coche.fecha_final) BETWEEN DATE(?) AND DATE(?))
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
                                        <div class='tarjeta row g-4'>
                                            <a href='/src/pages/rentacar/coche?matricula=" . $vehiculo_normal['matricula'] . "' class='text-decoration-none text-dark'>
                                            <div class='dentro-tarjeta card shadow'>
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
                        $checkear_coches = true;
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
        <div class="col-12">
            <div class="container my-4 ">
                <!-- TARJETAS -->
                <!-- Tarjetas Premium -->
                <div class="row row-cols-1 row-cols-md-4 g-4 ">
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
                                        <div class='tarjeta row g-4'>
                                            <a href='/src/pages/rentacar/coche?matricula=" . $vehiculo_premium['matricula'] . "' class='text-decoration-none text-dark'>
                                            <div class='dentro-tarjeta card h-100 shadow-lg border-warning'>
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
                <div class="row row-cols-1 row-cols-md-4 g-4 ">
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
                                        <div class='tarjeta row g-4'>
                                            <a href='/src/pages/rentacar/coche?matricula=" . $vehiculo_plus['matricula'] . "' class='text-decoration-none text-dark'>
                                            <div class='dentro-tarjeta card shadow'>
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
                <div class="row row-cols-1 row-cols-md-4 g-4 ">
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
                                        <div class='tarjeta row g-4'>
                                            <a href='/src/pages/rentacar/coche?matricula=" . $vehiculo_normal['matricula'] . "' class='text-decoration-none text-dark'>
                                            <div class='dentro-tarjeta card shadow'>
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


        // 4. OSCURECER PAGINA CON EL MENU
        const offcanvas = document.getElementById('filtrosOffcanvas');
        const overlay = document.getElementById('offcanvas-overlay');

        offcanvas.addEventListener('show.bs.offcanvas', () => {
            overlay.style.display = 'block';
        });

        offcanvas.addEventListener('hidden.bs.offcanvas', () => {
            overlay.style.display = 'none';
        });

        // Cierra también el menú si se hace clic en el overlay
        overlay.addEventListener('click', () => {
            const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvas);
            offcanvasInstance.hide();
        });
    </script>
    <div id="offcanvas-overlay"></div>


    <script>
document.addEventListener('DOMContentLoaded', function () {
    const marcaSelect = document.getElementById('marca-filtro');
    // El select de modelo ya no existe, así que no lo buscamos ni lo usamos

    // Cargar marcas desde la API
    fetch('https://vpic.nhtsa.dot.gov/api/vehicles/GetMakesForVehicleType/car?format=json')
        .then(res => res.json())
        .then(data => {
            let marcas = data.Results || [];
            marcas.sort((a, b) => a.MakeName.localeCompare(b.MakeName));
            let marcaSeleccionada = "<?php echo isset($_GET['marca']) ? addslashes($_GET['marca']) : ''; ?>";
            marcas.forEach(function (marca) {
                const option = document.createElement('option');
                option.value = marca.MakeName;
                option.textContent = marca.MakeName;
                if (marcaSeleccionada && marcaSeleccionada === marca.MakeName) {
                    option.selected = true;
                }
                marcaSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al cargar marcas:', error);
        });

    marcaSelect.addEventListener('change', function () {
        cargarModelos(this.value, "");
    });
});
</script>

</body>

</html>