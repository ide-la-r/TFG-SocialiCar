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

    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    require(__DIR__ . "/../../config/conexion.php");

    session_start();
    $matricula = $_GET['matricula'];
    ?>
</head>

<body>
    <?php include_once '../../components/navbar.php'; ?>
    <div class="container mt-5">
        <div class="row">
            <!-- Imagenes del coche -->
            <div class="col-md-6 mb-4">
                <?php
                $obtener_imagenes = $_conexion->prepare("
                        SELECT ruta_img_coche
                        FROM imagen_coche
                        WHERE id_coche = ?
                    ");
                $obtener_imagenes->bind_param("s", $matricula);
                $obtener_imagenes->execute();
                $resultado_imagenes = $obtener_imagenes->get_result();

                // Verificar si se encontraron imágenes
                if ($resultado_imagenes->num_rows > 0) {
                    $imagenes = [];
                    // Almacenar todas las imágenes en un array
                    while ($imagen = $resultado_imagenes->fetch_assoc()) {
                        $imagenes[] = $imagen['ruta_img_coche'];
                    }
                } else {
                    $imagenes = ['ruta/por/defecto.jpg']; // Imagen por defecto si no se encuentran imágenes
                }

                // Mostrar la primera imagen
                $imagen_principal = $imagenes[0];
                ?>

                <!-- Imagen principal -->
                <img src="<?php echo $imagen_principal; ?>" alt="Imagen coche" class="img-fluid rounded mb-3 product-image" id="mainImage">

                <div class="d-flex justify-content-between">
                    <?php
                    // Mostrar miniaturas
                    foreach ($imagenes as $imagen) {
                        echo "<img src='$imagen' alt='Imagen coche' class='thumbnail rounded' onclick='changeImage(event, this.src)'>";
                    }
                    ?>
                </div>
            </div>

            <!-- Descripción del vehículo -->
            <div class="col-md-6">

                <?php
                $sql = $_conexion->prepare("SELECT * FROM coche WHERE matricula = ?");
                $sql->bind_param("s", $matricula);
                $sql->execute();
                $resultado = $sql->get_result();

                while ($fila = $resultado->fetch_assoc()) {
                    $marca = $fila['marca'];
                    $modelo = $fila['modelo'];
                    $precio = $fila['precio'];
                    $descripcion = $fila['descripcion'];
                    $color = $fila['color'];
                    switch ($color) {
                        case "white":
                            $color_esp = "Blanco";
                            break;
                        case "black":
                            $color_esp = "Negro";
                            break;
                        case "gray":
                            $color_esp = "Gris";
                            break;
                        case "red":
                            $color_esp = "Rojo";
                            break;
                        case "blue":
                            $color_esp = "Azul";
                            break;
                        case "green":
                            $color_esp = "Verde";
                            break;
                        case "yellow":
                            $color_esp = "Amarillo";
                            break;
                        case "orange":
                            $color_esp = "Naranja";
                            break;
                        case "brown":
                            $color_esp = "Marrón";
                            break;
                        case "other":
                            $color_esp = "Otros";
                            break;
                    }
                    $kilometros = $fila['kilometros'];
                    $transmision = $fila['transmision'];
                    $combustible = $fila['combustible'];
                    $ciudad = $fila['ciudad'];
                }


                echo "
                        <h2 class='mb-3'>$marca $modelo</h2>
                        <p class='text-muted mb-4'>Matricula: $matricula</p>
                        <div class='mb-3'>
                            <span class='h4 me-2'>$precio € / día</span>
                        </div>
                        
                    ";

                ?>

                <!-- Valoraciones -->
                <div class="mb-3">
                    <span class="ms-2">4.5 (120 reviews)</span>
                </div>

                <!-- Color -->
                <div class="mb-4">
                    <h5>Color:</h5>
                    <div class='btn-group' role='group' aria-label='Color selection'>
                        <input type='radio' class='btn-check' name='color' id='<?php echo $color; ?>' autocomplete='off' checked>
                        <label class='btn btn-outline-secondary' for='<?php echo $color; ?>' style="background-color:
                        <?php
                            if ($color_esp == "Otros") {
                                echo "#808080";
                            } else {
                                echo $color;
                            }
                        ?>; color: white;">
                            <?php echo ucfirst($color_esp); ?>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <a href="/src/pages/chat/chat.php?matricula=<?php echo $matricula; ?>" class="btn btn-outline-primary">
                        <i class="bi bi-message"></i> Chat
                    </a>
                </div>

                <!-- Botones -->
                <button class="btn btn-primary btn-lg mb-3 me-2" id="btn-alquilar">
                    <i class="bi bi-cart-plus"></i> ¡Alquilar!
                </button>

                <button class="btn btn-outline-secondary btn-lg mb-3">
                    <i class="bi bi-heart"></i> Agregar a favoritos
                </button>
            </div>

            <!-- Detalles detallados del vehículo -->
            <div class="col-md-12">
                <?php
                echo "
                        <div class='mb-3'>
                            <h5 class='mt-4'>Descripción:</h5>
                            <p class='text-muted mb-4'>$descripcion</p>
                        </div>
                        ";

                $sql_extras = $_conexion->prepare("SELECT * FROM extras_coche WHERE matricula = ?");
                $sql_extras->bind_param("s", $matricula);
                $sql_extras->execute();
                $resultado_extras = $sql_extras->get_result();
                while ($fila_extras = $resultado_extras->fetch_assoc()) {
                    $aire_acondicionado = $fila_extras['aire_acondicionado'];
                    $gps = $fila_extras['gps'];
                    $wifi = $fila_extras['wifi'];
                    $sensores_aparcamiento = $fila_extras['sensores_aparcamiento'];
                    $camaras_reversa = $fila_extras['camara_trasera'];
                    $control_de_crucero = $fila_extras['control_de_crucero'];
                    $asientos_calefactables = $fila_extras['asientos_calefactables'];
                    $bola_remolque = $fila_extras['bola_remolque'];
                    $fijacion_isofix = $fila_extras['fijacion_isofix'];
                    $apple_carplay = $fila_extras['apple_carplay'];
                    $android_carplay = $fila_extras['android_carplay'];
                    $baca = $fila_extras['baca'];
                    $portabicicletas = $fila_extras['portabicicletas'];
                    $portaequipajes = $fila_extras['portaequipajes'];
                    $portaesquis = $fila_extras['portaesquis'];
                    $bluetooth = $fila_extras['bluetooth'];
                    $cuatro_x_cuatro = $fila_extras['cuatro_x_cuatro'];
                    $mascota = $fila_extras['mascota'];
                    $fumar = $fila_extras['fumar'];
                    $movilidad_reducida = $fila_extras['movilidad_reducida'];
                };
                ?>
                <!-- Mostrar extras -->
                <div class="mt-4">

                    <?php
                    if ($resultado_extras->num_rows > 0) {
                        echo "<h5>Extras del vehículo</h5>";
                        echo "<ul class='list-group'>";
                        if ($aire_acondicionado == 1) {
                            echo "<li class='list-group-item'>Aire acondicionado</li>";
                        }
                        if ($gps == 1) {
                            echo "<li class='list-group-item'>GPS</li>";
                        }
                        if ($wifi == 1) {
                            echo "<li class='list-group-item'>Wifi</li>";
                        }
                        if ($sensores_aparcamiento == 1) {
                            echo "<li class='list-group-item'>Sensores de aparcamiento</li>";
                        }
                        if ($camaras_reversa == 1) {
                            echo "<li class='list-group-item'>Cámara de reversa</li>";
                        }
                        if ($control_de_crucero == 1) {
                            echo "<li class='list-group-item'>Control de crucero</li>";
                        }
                        if ($asientos_calefactables == 1) {
                            echo "<li class='list-group-item'>Asientos calefactables</li>";
                        }
                        if ($bola_remolque == 1) {
                            echo "<li class='list-group-item'>Bola de remolque</li>";
                        }
                        if ($fijacion_isofix == 1) {
                            echo "<li class='list-group-item'>Fijación Isofix</li>";
                        }
                        if ($apple_carplay == 1) {
                            echo "<li class='list-group-item'>Apple Carplay</li>";
                        }
                        if ($android_carplay == 1) {
                            echo "<li class='list-group-item'>Android Carplay</li>";
                        }
                        if ($baca == 1) {
                            echo "<li class='list-group-item'>Baca</li>";
                        }
                        if ($portabicicletas == 1) {
                            echo "<li class='list-group-item'>Portabicicletas</li>";
                        }
                        if ($portaequipajes == 1) {
                            echo "<li class='list-group-item'>Portaequipajes</li>";
                        }
                        if ($portaesquis == 1) {
                            echo "<li class='list-group-item'>Portaesquís</li>";
                        }
                        if ($bluetooth == 1) {
                            echo "<li class='list-group-item'>Bluetooth</li>";
                        }
                        if ($cuatro_x_cuatro == 1) {
                            echo "<li class='list-group-item'>4x4</li>";
                        }
                        if ($mascota == 1) {
                            echo "<li class='list-group-item'>Mascota</li>";
                        }
                        if ($fumar == 1) {
                            echo "<li class='list-group-item'>Fumar</li>";
                        }
                        if ($movilidad_reducida == 1) {
                            echo "<li class='list-group-item'>Movilidad reducida</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<h5>No hay extras disponibles para este vehículo</h5>";
                    }
                    ?>
                </div>
                <div class="mt-4">
                    <h5>Lugar de recogida y devolución</h5>
                    <p>La dirección exacta aparecerá después de realizar la reserva.</p>
                    <!-- Mapa con la ubicación -->
                    <?php
                    $sql_ubicacion = $_conexion->prepare("SELECT direccion, ciudad, codigo_postal FROM coche WHERE matricula = ?");
                    $sql_ubicacion->bind_param("s", $matricula);
                    $sql_ubicacion->execute();
                    $resultado_ubicacion = $sql_ubicacion->get_result();
                    if ($fila = $resultado_ubicacion->fetch_assoc()) {
                        $direccion_limpia = preg_replace('/,\s*\d+[^\d\s]*/', '', $fila['direccion']);
                        $direccion_completa = $direccion_limpia . ', ' . $fila['codigo_postal'] . ' ' . $fila['ciudad'];
                    } else {
                        $direccion_completa = 0;
                    }

                    if ($direccion_completa == 0) {
                        echo "<p class='text-danger'>No se ha encontrado la dirección del vehículo.</p>";
                    } else { ?>
                        <div id="map" style="height: 400px;" data-direccion="<?php echo htmlspecialchars($direccion_completa); ?>"></div>
                    <?php }
                    ?>


                </div>
            </div>
        </div>
    </div>
    <?php include_once '../../components/footer.php'; ?>
    <script src="/src/js/mapa_coche.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        function changeImage(event, src) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
            event.target.classList.add('active');
        }
    </script>
</body>