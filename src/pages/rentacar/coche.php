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
            color: #FF6F61;
            font-weight: bold;
            font-size: 14px;
            border: none;
            box-shadow: none;
        }

        body {
            position: relative;
            background: url('../../img/perfil_nuevo.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            margin: 0;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right,
                    rgba(73, 73, 73, 0.4) 0%,
                    rgba(184, 232, 235, 0.3) 58%,
                    rgba(114, 114, 114, 0.7) 100%);
            z-index: 0;
            pointer-events: none;
        }

        /* Nuevos estilos añadidos */
        .product-image {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            max-height: 400px;
            width: 100%;
            object-fit: cover;
        }

        .product-image:hover {
            transform: scale(1.02);
        }

        .thumbnail {
            width: 80px;
            height: 60px;
            object-fit: cover;
            margin-right: 10px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            border-radius: 5px;
        }

        .thumbnail:hover {
            border-color: #6BBFBF;
            transform: translateY(-3px);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: white;
            margin-bottom: 20px;
            padding: 25px;
            height: 100%;
        }

        .info-card {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .accordion {
            --bs-accordion-btn-icon: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%236BBFBF'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            --bs-accordion-btn-active-icon: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%236BBFBF'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            --bs-accordion-active-color: #6BBFBF;
            --bs-accordion-btn-focus-box-shadow: 0 0 0 0.25rem rgba(107, 191, 191, 0.25);
        }

        .accordion-item {
            margin-bottom: 15px;
            border: none;
            border-radius: 10px !important;
            overflow: hidden;
            background-color: white;
            border: 1px solid #dee2e6;
        }

        .accordion-button {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .accordion-button:not(.collapsed) {
            background-color: #e9ecef;
            color: #333;
            box-shadow: none;
        }

        .accordion-button:focus {
            border-color: #6BBFBF;
            box-shadow: none;
        }

        .btn-lg {
            padding: 0.5rem 1.5rem;
            font-size: 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary {
            border-color: #6BBFBF;
            color: #6BBFBF;
        }

        .btn-outline-primary:hover {
            background-color: #6BBFBF;
            color: white;
        }

        .btn-success {
            background-color: #6BBFBF;
            border-color: #6BBFBF;
        }

        .btn-success:hover {
            background-color: #5aa8a8;
            border-color: #5aa8a8;
        }

        .btn-outline-secondary {
            border-color: #ddd;
            color: #666;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            color: #333;
        }

        .reserva-fechas {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .list-group-item {
            border-left: none;
            border-right: none;
            padding: 0.75rem 1.25rem;
            background-color: transparent;
        }

        .list-group-item:first-child {
            border-top: none;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .price-tag {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .rating i {
            font-size: 1.2rem;
        }

        .feature-icon {
            color: #6BBFBF;
            margin-right: 8px;
        }

        #map {
            border-radius: 10px;
            border: 1px solid #e0e0e0;
        }

        .color-btn {
            min-width: 100px;
            text-transform: capitalize;
        }

        .color-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid #ddd;
            display: inline-block;
            margin-right: 10px;
        }

        .specs-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .spec-item {
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .thumbnail {
                width: 60px;
                height: 45px;
            }
            
            .btn-lg {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            
            .card {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <?php include_once '../../components/navbar.php'; ?>
    <div class="container mt-5">
        <!-- Row principal con altura igualada -->
        <div class="row d-flex align-items-stretch">
            <!-- Columna de imágenes -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
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

                    <div class="d-flex flex-wrap justify-content-start mt-3">
                        <?php foreach ($imagenes as $imagen) {
                            echo "<img src='$imagen' alt='Imagen coche' class='thumbnail rounded me-2 mb-2' onclick='changeImage(event, this.src)'>";
                        } ?>
                    </div>
                </div>
            </div>

            <!-- Columna de información -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
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

                        echo "<h2 class='mb-3 fw-bold'>$marca $modelo</h2>
                              <p class='text-muted mb-4'><i class='bi bi-tag-fill me-2'></i> Matrícula: $matricula</p>
                              <div class='mb-4'><span class='price-tag me-2'>$precio €</span><span class='text-muted'>/ día</span></div>";
                    }
                    ?>

                    <div class="mb-4 d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-half text-warning"></i>
                            <span class="ms-2 text-muted">4.5 (120 valoraciones)</span>
                        </div>
                        <div class="badge bg-success bg-opacity-10 text-success">
                            <i class="bi bi-check-circle-fill me-1"></i> Disponible
                        </div>
                    </div>

                    <div class="specs-container mb-4">
                        <div class="row">
                            <div class="col-md-6 spec-item">
                                <h5 class="mb-2"><i class="bi bi-palette-fill feature-icon"></i> Color:</h5>
                                <div class="d-flex align-items-center">
                                    <div class="color-circle" style="background-color: <?php echo ($color_esp == 'Otros') ? '#808080' : $color; ?>"></div>
                                    <span class="fw-medium"><?php echo ucfirst($color_esp); ?></span>
                                </div>
                            </div>

                            <div class="col-md-6 spec-item">
                                <h5 class="mb-2"><i class="bi bi-speedometer2 feature-icon"></i> Kilometraje:</h5>
                                <span class="fw-medium"><?php echo number_format($kilometros, 0, ',', '.'); ?> km</span>
                            </div>

                            <div class="col-md-6 spec-item">
                                <h5 class="mb-2"><i class="bi bi-gear-fill feature-icon"></i> Transmisión:</h5>
                                <span class="fw-medium"><?php echo ($transmision == 'automatico') ? 'Automática' : 'Manual'; ?></span>
                            </div>

                            <div class="col-md-6 spec-item">
                                <h5 class="mb-2"><i class="bi bi-fuel-pump-fill feature-icon"></i> Combustible:</h5>
                                <span class="fw-medium"><?php 
                                    $combustibles = [
                                        'gasolina' => 'Gasolina',
                                        'diesel' => 'Diésel',
                                        'electrico' => 'Eléctrico',
                                        'hibrido' => 'Híbrido'
                                    ];
                                    echo $combustibles[$combustible] ?? ucfirst($combustible); 
                                ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 reserva-fechas">
                        <h5 class="mb-3"><i class="bi bi-calendar-range-fill feature-icon"></i> Selecciona tu rango de reserva</h5>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control mb-2" placeholder="Fecha de inicio">
                        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control mb-2" placeholder="Fecha de fin">
                        <div class="mt-3">
                            <span class="fw-bold">Total a pagar: </span>
                            <span id="precioTotal" class="fs-5 text-primary"><?= $precio ?> €</span>
                        </div>
                    </div>
                    <div class="mb-4 d-flex gap-2 flex-wrap">
                        <?php
                        $duenio_id = $fila['id_usuario'];
                        $matricula = $fila['matricula'];

                        if (isset($_SESSION['usuario'])) {
                            $usuario_sesion = $_SESSION['usuario']['identificacion'];

                            if ($usuario_sesion != $duenio_id) {
                                echo "<a href='/src/pages/chat/conversa?matricula=$matricula&chat_con=$duenio_id' class='btn btn-outline-primary btn-lg flex-grow-1'>
                                        <i class='bi bi-chat-dots me-2'></i> Contactar
                                      </a>";
                                echo '<form action="" method="post" class="flex-grow-1">
                                        <a href="../pago/iniciar_pago.php?tipo=coche&precio_coche=' . $precio . '" class="btn btn-success btn-lg w-100">
                                            <i class="bi bi-cart-plus me-2"></i> Alquilar
                                        </a>
                                     </form>';
                            } else {
                                echo "<a href='/src/pages/coche/editar_coche?matricula=$matricula' class='btn btn-outline-primary btn-lg flex-grow-1'>
                                        <i class='bi bi-pencil-square me-2'></i> Editar
                                      </a>";
                            }
                        } else {
                            echo "<a href='/src/pages/usuario/iniciar_sesion' class='btn btn-outline-primary btn-lg flex-grow-1'>
                                    <i class='bi bi-lock-fill me-2'></i> Iniciar sesión
                                  </a>";
                        }
                        ?>
                        <form action="" method="post" class="flex-grow-1" id="formAlquilar">
                            <a href="../pago/iniciar_pago.php?tipo=coche&precio_coche=<?= $precio; ?>" class="btn btn-success btn-lg w-100" id="alquilarBtn">
                                <i class="bi bi-cart-plus me-2"></i> Alquilar
                            </a>
                        </form>

                        <button class="btn btn-outline-secondary btn-lg flex-grow-1">
                            <i class="bi bi-heart me-2"></i> Favoritos
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de descripción y extras -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="accordion" id="vehicleDetailsAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingDescription">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDescription" aria-expanded="false" aria-controls="collapseDescription">
                                    <i class="bi bi-card-text feature-icon me-2"></i> Descripción del vehículo
                                </button>
                            </h2>
                            <div id="collapseDescription" class="accordion-collapse collapse" aria-labelledby="headingDescription" data-bs-parent="#vehicleDetailsAccordion">
                                <div class="accordion-body">
                                    <p class="mb-0"><?php echo $descripcion; ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingExtras">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExtras" aria-expanded="false" aria-controls="collapseExtras">
                                    <i class="bi bi-list-check feature-icon me-2"></i> Extras y características
                                </button>
                            </h2>
                            <div id="collapseExtras" class="accordion-collapse collapse" aria-labelledby="headingExtras" data-bs-parent="#vehicleDetailsAccordion">
                                <div class="accordion-body">
                                    <?php
                                    $sql_extras = $_conexion->prepare("SELECT * FROM extras_coche WHERE matricula = ?");
                                    $sql_extras->bind_param("s", $matricula);
                                    $sql_extras->execute();
                                    $resultado_extras = $sql_extras->get_result();

                                    if ($resultado_extras->num_rows > 0) {
                                        $extras = $resultado_extras->fetch_assoc();
                                        $extras_filtrados = array();
                                        foreach ($extras as $nombre => $valor) {
                                            if ($valor == 1) {
                                                $nombre_legible = ucwords(str_replace('_', ' ', $nombre));
                                                $extras_filtrados[] = $nombre_legible;
                                            }
                                        }
                                        if (count($extras_filtrados) > 0) {
                                            echo '<div class="row">';
                                            foreach ($extras_filtrados as $extra) {
                                                echo '<div class="col-md-4 mb-2">';
                                                echo '<div class="d-flex align-items-center">';
                                                echo '<i class="bi bi-check-circle-fill text-success me-2"></i>';
                                                echo '<span>' . $extra . '</span>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                            echo '</div>';
                                        } else {
                                            echo '<p class="text-muted">Este vehículo no tiene extras destacados.</p>';
                                        }
                                    } else {
                                        echo '<p class="text-muted">No hay información de extras para este vehículo.</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mapa -->
            <div class="col-12 mt-4">
                <div class="card p-4">
                    <h3 class="mb-4"><i class="bi bi-geo-alt-fill feature-icon me-2"></i> Ubicación del vehículo</h3>
                    <p class="text-muted mb-3"><i class="bi bi-house-door-fill me-2"></i> <?php echo $direccion_usable; ?></p>
                    <div id="map" data-direccion="<?php echo $direccion_usable; ?>" style="height: 400px;" class="mt-3 rounded shadow-sm"></div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once '../../components/footer-example.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        function changeImage(event, src) {
            event.preventDefault();
            document.getElementById('mainImage').src = src;
            
            // Remover clase activa de todas las miniaturas
            document.querySelectorAll('.thumbnail').forEach(function(thumb) {
                thumb.classList.remove('active-thumbnail');
                thumb.style.borderColor = 'transparent';
            });
            
            // Añadir clase activa a la miniatura clickeada
            event.target.classList.add('active-thumbnail');
            event.target.style.borderColor = '#6BBFBF';
        }

        // Activar la primera miniatura por defecto
        document.addEventListener('DOMContentLoaded', function() {
            const firstThumbnail = document.querySelector('.thumbnail');
            if (firstThumbnail) {
                firstThumbnail.classList.add('active-thumbnail');
                firstThumbnail.style.borderColor = '#6BBFBF';
            }
            
            // Inicializar los acordeones
            const accordion = new bootstrap.Collapse(document.getElementById('collapseDescription'), {
                toggle: false
            });
            const accordion2 = new bootstrap.Collapse(document.getElementById('collapseExtras'), {
                toggle: false
            });
        });

        // Calcular precio total según días seleccionados
        document.addEventListener('DOMContentLoaded', function() {
            var precioPorDia = <?= (int)$precio ?>;
            var fechaInicioInput = document.getElementById('fecha_inicio');
            var fechaFinInput = document.getElementById('fecha_fin');
            var precioTotalSpan = document.getElementById('precioTotal');
            var alquilarBtn = document.getElementById('alquilarBtn');

            function calcularTotal() {
                var inicio = fechaInicioInput.value;
                var fin = fechaFinInput.value;
                if (inicio && fin) {
                    var d1 = new Date(inicio);
                    var d2 = new Date(fin);
                    var diff = Math.round((d2 - d1) / (1000 * 60 * 60 * 24)) + 1;
                    var dias = diff > 0 ? diff : 1;
                    var total = precioPorDia * dias;
                    precioTotalSpan.textContent = total + " €";
                    if (alquilarBtn) {
                        alquilarBtn.href = "../pago/iniciar_pago.php?tipo=coche&precio_coche=" + total;
                    }
                } else {
                    precioTotalSpan.textContent = precioPorDia + " €";
                    if (alquilarBtn) {
                        alquilarBtn.href = "../pago/iniciar_pago.php?tipo=coche&precio_coche=" + precioPorDia;
                    }
                }
            }

            fechaInicioInput.addEventListener('change', calcularTotal);
            fechaFinInput.addEventListener('change', calcularTotal);
        });
    </script>
    <script src="../../js/fecha_rango.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="../../js/mostrar_mapa.js"></script>

</body>

</html>