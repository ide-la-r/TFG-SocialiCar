<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="../../../src/styles/index.css">
    <link rel="stylesheet" href="../../../src/styles/coche.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    require(__DIR__ . "/../../config/conexion.php");

    session_start();
    $matricula = $_GET['matricula'] ?? '';
    ?>

    <style>
        .text-shadow {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        .zona-entrega-tooltip {
            background: transparent;
            color: #FF6F61; /* Color suave, en línea con el estilo de Google Maps */
            font-weight: bold;
            font-size: 14px;
            border: none;
            box-shadow: none;
        }

    </style>
</head>

<body>
    <?php include_once '../../components/navbar.php'; ?>
    <div class="container mt-5">
        <div class="row">
            <!-- Imagenes del coche -->
            <div class="col-md-6 mb-4">
                <?php
                $obtener_imagenes = $_conexion->prepare("SELECT ruta_img_coche FROM imagen_coche WHERE id_coche = ?");
                $obtener_imagenes->bind_param("s", $matricula);
                $obtener_imagenes->execute();
                $resultado_imagenes = $obtener_imagenes->get_result();

                $imagenes = ($resultado_imagenes->num_rows > 0)
                    ? array_column($resultado_imagenes->fetch_all(MYSQLI_ASSOC), 'ruta_img_coche')
                    : ['../../../src/img/default-car.jpg'];

                $imagen_principal = $imagenes[0];
                ?>

                <img src="<?php echo $imagen_principal; ?>" alt="Imagen coche" class="img-fluid rounded mb-3 product-image" id="mainImage">

                <div class="d-flex justify-content-between">
                    <?php foreach ($imagenes as $imagen) {
                        echo "<img src='$imagen' alt='Imagen coche' class='thumbnail rounded' onclick='changeImage(event, this.src)'>";
                    } ?>
                </div>
            </div>

            <!-- Descripción del vehículo -->
            <div class="col-md-6">
                <?php
                $sql = $_conexion->prepare("SELECT * FROM coche WHERE matricula = ?");
                $sql->bind_param("s", $matricula);
                $sql->execute();
                $resultado = $sql->get_result();

                if ($fila = $resultado->fetch_assoc()) {
                    $marca = $fila['marca'];
                    $modelo = $fila['modelo'];
                    $precio = $fila['precio'];
                    $descripcion = $fila['descripcion'];
                    $color = $fila['color'];
                    $kilometros = $fila['kilometros'];
                    $transmision = $fila['transmision'];
                    $combustible = $fila['combustible'];
                    $ciudad = $fila['ciudad'];
                    $direccion = $fila['direccion'];
                    $codigo_postal = $fila['codigo_postal'];

                    $partes = explode(',', $direccion);
                    if (is_numeric($partes[0])) {
                        if (isset($partes[1])) {
                            $calle = trim($partes[1]);
                        } else {
                            $calle = trim($partes[0]);
                        }
                    } else {
                        $calle = trim($partes[0]);
                    }
                    $direccion_usable = "$calle, $codigo_postal, $ciudad, España";

                    $colores = [
                        "white" => "Blanco", "black" => "Negro", "gray" => "Gris", "red" => "Rojo",
                        "blue" => "Azul", "green" => "Verde", "yellow" => "Amarillo", "orange" => "Naranja",
                        "brown" => "Marrón", "other" => "Otros"
                    ];

                    $color_esp = $colores[$color] ?? "Otros";

                    echo "<h2 class='mb-3'>$marca $modelo</h2>
                          <p class='text-muted mb-4'>Matrícula: $matricula</p>
                          <div class='mb-3'><span class='h4 me-2'>$precio € / día</span></div>";
                }
                ?>

                <!-- Valoraciones -->
                <div class="mb-3">
                    <span class="ms-2">4.5 (120 reviews)</span>
                </div>

                <!-- Color -->
                <div class="mb-4">
                    <h5 class="d-inline-block me-3">Color:</h5>
                    <div class="d-inline-block">
                        <div class="btn-group" role="group" aria-label="Color selection">
                            <input type="radio" class="btn-check" name="color" id="<?php echo $color; ?>" autocomplete="off" checked>
                            <label class="btn btn-outline-secondary text-shadow" for="<?php echo $color; ?>" style="background-color: <?php echo ($color_esp == 'Otros') ? '#808080' : $color; ?>; color: white;">
                                <?php echo ucfirst($color_esp); ?>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Fechas de reserva -->
                <div class="mb-4 reserva-fechas">
                    <h5>Selecciona tu rango de reserva</h5>
                    <input type="text" id="fecha_rango" class="form-control" placeholder="Elige el rango de fechas" readonly>

                    <input type="hidden" id="fecha_inicio" name="fecha_inicio">
                    <input type="hidden" id="fecha_fin" name="fecha_fin">
                </div>

                <div class="mb-4">
                    <?php
                        $duenio_id = $fila['id_usuario'];  // ID del dueño del coche
                        $matricula = $fila['matricula'];   // Asegúrate de tener la matrícula disponible

                        if (isset($_SESSION['usuario'])) {
                            $usuario_sesion = $_SESSION['usuario'];

                            // Verificar que el usuario no sea el mismo que el dueño del coche
                            if ($usuario_sesion == $duenio_id) {
                                echo "<a href='/src/pages/chat/conversa?matricula=$matricula&chat_con=$duenio_id' class='btn btn-outline-primary'>
                                        <i class='bi bi-chat-dots'></i> Chat
                                    </a>";
                            } else {
                                echo "<a href='/src/pages/coche/editar_coche?matricula=$matricula' class='btn btn-outline-primary'>
                                        <i class='bi bi-tools'></i> Editar coche
                                    </a>";
                            }
                        } else {
                            echo "<a href='/src/pages/usuario/iniciar_sesion' class='btn btn-outline-primary'>
                                    <i class='bi bi-lock-fill'></i> Inicia sesión para chatear
                                </a>";
                        }
                    ?>
                </div>

                <form action="" method="post">
                    <a href="../pago/iniciar_pago.php?tipo=coche&precio_coche=<?= $precio; ?>" class="btn btn-primary btn-lg mb-3 me-2" id="btn-alquilar">
                        <i class="bi bi-cart-plus"></i> ¡Alquilar!
                    </a>
                </form>
                

                <button class="btn btn-outline-secondary btn-lg mb-3">
                    <i class="bi bi-heart"></i> Agregar a favoritos
                </button>
            </div>

            <!-- Descripción completa y extras -->
            <div class="col-md-12">
                <?php echo "<div class='mb-3'><h5 class='mt-4'>Descripción:</h5><p class='text-muted mb-4'>$descripcion</p></div>"; ?>

                <?php
                $sql_extras = $_conexion->prepare("SELECT * FROM extras_coche WHERE matricula = ?");
                $sql_extras->bind_param("s", $matricula);
                $sql_extras->execute();
                $resultado_extras = $sql_extras->get_result();

                if ($resultado_extras->num_rows > 0) {
                    $extras = $resultado_extras->fetch_assoc();
                    echo "<h5>Extras del vehículo</h5><ul class='list-group'>";
                    foreach ($extras as $nombre => $valor) {
                        if ($valor == 1) {
                            $nombre_legible = ucwords(str_replace('_', ' ', $nombre));
                            echo "<li class='list-group-item'>$nombre_legible</li>";
                        }
                    }
                    echo "</ul>";
                }
                ?>
            </div>
        </div>
    </div><br>

    <?php include_once '../../components/footer-example.php'; ?>

    <script>
        function changeImage(event, src) {
            document.getElementById('mainImage').src = src;
        }
    </script>
    <script src="../../js/fecha_rango.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="../../js/mostrar_mapa.js"></script>
    
</body>
</html>
