<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="../../styles/nuevo_coche_custom.css">
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    require(__DIR__ . "/../../config/conexion.php");

    session_start();
    // Redirigir si no hay sesión iniciada
    if (!isset($_SESSION['usuario'])) {
        header("Location: ../../../");
        exit();
    }
    ?>
    <style>
        .error {
            color: #e03131;
            font-size: 1em;
        }

        body {
            position: relative;
            background: url('../../img/fondo_editar.jpg');
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


        
        .card {
            border-radius: 30px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.9);
            margin: 1rem auto;
            max-width: 800px;
        }


        h3 {
            color: #222831;
            font-weight: 700;
            font-size: 2.4rem;
            margin-bottom: 2rem;
            border-left: 6px solid #00adb5;
            padding-left: 1rem;
            align-self: flex-start;
            text-align: left;
        }



        /* PONER EN LOS DEMAS ARCHIVOS */
        .form-floating>.form-control,
        .form-floating>.form-select {
            border: 1px solid black;
            border-radius: 20px;
        }

    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php
    require(__DIR__ . "/../../config/depurar.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tmp_matricula = depurar($_POST['matricula']);
        $tmp_precio = depurar($_POST['precio']);
        $id_usuario = $_SESSION["usuario"]["identificacion"];

        if ($_POST["lat"] != "") {
            $lat = $_POST["lat"];
        } else {
            $lat = 0;
        }

        if ($_POST["lon"] != "") {
            $lon = $_POST["lon"];
        } else {
            $lon = 0;
        }

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

        if (isset($_POST['color'])) {
            $tmp_color = depurar($_POST['color']);
        } else {
            $tmp_color = "";
        }

        $tmp_anno_matriculacion = depurar($_POST['anno_matriculacion']);
        $tmp_kilometros = depurar($_POST['kilometros']);
        $tmp_direccion = $_POST['direccion'];
        $tmp_descripcion = depurar($_POST['descripcion']);
        $tmp_potencia = $_POST['potencia'];
        $tmp_numero_puertas = $_POST['numero_puertas'];
        $tmp_numero_plazas = $_POST['numero_plazas'];


        if (isset($_POST['movilidad_reducida']) && $_POST['movilidad_reducida'] == 'on') {
            $movilidad_reducida = 1;
        } else {
            $movilidad_reducida = 0;
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

        if (isset($_POST['sensores_aparcamiento']) && $_POST['sensores_aparcamiento'] == 'on') {
            $sensores_aparcamiento = 1;
        } else {
            $sensores_aparcamiento = 0;
        }

        if (isset($_POST['camara_trasera']) && $_POST['camara_trasera'] == 'on') {
            $camara_trasera = 1;
        } else {
            $camara_trasera = 0;
        }

        if (isset($_POST['control_de_crucero']) && $_POST['control_de_crucero'] == 'on') {
            $control_de_crucero = 1;
        } else {
            $control_de_crucero = 0;
        }

        if (isset($_POST['asientos_calefactables']) && $_POST['asientos_calefactables'] == 'on') {
            $asientos_calefactables = 1;
        } else {
            $asientos_calefactables = 0;
        }

        if (isset($_POST['aire_acondicionado']) && $_POST['aire_acondicionado'] == 'on') {
            $aire_acondicionado = 1;
        } else {
            $aire_acondicionado = 0;
        }

        if (isset($_POST['bola_remolque']) && $_POST['bola_remolque'] == 'on') {
            $bola_remolque = 1;
        } else {
            $bola_remolque = 0;
        }

        if (isset($_POST['fijacion_isofix']) && $_POST['fijacion_isofix'] == 'on') {
            $fijacion_isofix = 1;
        } else {
            $fijacion_isofix = 0;
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

        if (isset($_POST['cuatro_x_cuatro']) && $_POST['cuatro_x_cuatro'] == 'on') {
            $cuatro_x_cuatro = 1;
        } else {
            $cuatro_x_cuatro = 0;
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

        /* Validación de matrícula */
        if (empty($tmp_matricula)) {
            $err_matricula = "Debes indicar la matrícula de tu coche";
        } else {
            // Limpieza y normalización
            $tmp_matricula = strtoupper($tmp_matricula);
            $tmp_matricula = preg_replace("/[\s\-\.,:]/", "", $tmp_matricula);

            // Validación de formato
            $patron_actual = "/^[0-9]{4}[BCDFGHJKLMNPRSTVWXYZ]{3}$/";
            $patron_antiguo = "/^[A-Z]{1,2}[0-9]{4,6}[A-Z]{0,2}$/";

            if (!preg_match($patron_actual, $tmp_matricula) && !preg_match($patron_antiguo, $tmp_matricula)) {
                $err_matricula = "La matrícula no es válida. Usa un formato correcto como 1234BCD o MA1234AB.";
            } else {
                // Verificación en base de datos
                $obtenerMatricula = $_conexion->prepare("SELECT * FROM coche WHERE matricula = ?");
                $obtenerMatricula->bind_param("s", $tmp_matricula);
                $obtenerMatricula->execute();
                $resultado = $obtenerMatricula->get_result();

                if ($resultado->num_rows == 1) {
                    $err_matricula = "Ya existe un coche con esta matrícula";
                } else {
                    $matricula = $tmp_matricula;
                }
            }
        }

        /* Validación de precio */
        if ($tmp_precio == "") {
            $err_precio = "Debes indicar el precio de tu coche";
        } else {
            if (!is_numeric($tmp_precio)) {
                $err_precio = "El precio debe ser un número";
            } else {
                if ($tmp_precio < 15 || $tmp_precio > 500) {
                    $err_precio = "El precio debe estar entre 15 y 500";
                } else {
                    $precio = $tmp_precio;
                }
            }
        }

        /* Validación de marca */
        if ($tmp_marca == "") {
            $err_marca = "Debes indicar la marca de tu coche";
        } else {
            if (strlen($tmp_marca) > 50) {
                $err_marca = "La marca no puede tener más de 50 caracteres";
            } else {
                $marca = $tmp_marca; /* Agregar más adelante la comprovación con la API de las marcas */
            }
        }

        /* Validación de modelo */
        if ($tmp_modelo == "") {
            $err_modelo = "Debes indicar el modelo de tu coche";
        } else {
            if (strlen($tmp_modelo) > 50) {
                $err_modelo = "El modelo no puede tener más de 50 caracteres";
            } else {
                $modelo = $tmp_modelo; /* Agregar más adelante la comprovación con la API de los modelos */
            }
        }

        /* Validación de año de matriculación */
        if ($tmp_anno_matriculacion == "") {
            $err_anno_matriculacion = "Debes indicar el año de matriculación de tu coche";
        } else {
            $patron_anno = "/^[0-9]{4}-[0-9]{2}$/";
            if (!preg_match($patron_anno, $tmp_anno_matriculacion)) {
                $err_anno_matriculacion = "El año de matriculación no es válido";
            } else {
                if ($tmp_anno_matriculacion > date("Y-m")) {
                    $err_anno_matriculacion = "El año de matriculación no puede ser mayor al actual";
                } else {
                    $anno_matriculacion = $tmp_anno_matriculacion . "-01";
                }
            }
        }

        /* Validación de kilómetros */
        if ($tmp_kilometros == "") {
            $err_kilometros = "Debes indicar los kilómetros de tu coche";
        } else {
            if (!is_numeric($tmp_kilometros)) {
                $err_kilometros = "Los kilómetros deben ser un número";
            } else {
                if ($tmp_kilometros < 0) {
                    $err_kilometros = "Los kilómetros no pueden ser negativos";
                } else {
                    $tmp_kilometros = str_replace(",", "", $tmp_kilometros);
                    $tmp_kilometros = str_replace(".", "", $tmp_kilometros);
                    $tmp_kilometros = str_replace(" ", "", $tmp_kilometros);
                    $kilometros = $tmp_kilometros;
                }
            }
        }

        /* Validación de dirección */
        if ($tmp_direccion == "") {
            $err_direccion = "Debes indicar la dirección de tu coche";
        } else {
            $partes_direccion = array_map('trim', explode(",", $tmp_direccion));
            $total = count($partes_direccion);

            if ($total < 5) {
                $err_direccion = "La dirección debe tener al menos 5 partes: Calle, Ciudad, Provincia, Código Postal, País.";
            } else {
                // Lista oficial de provincias de España
                $provincias_espana = [
                    "Álava", "Albacete", "Alicante", "Almería", "Asturias", "Ávila",
                    "Badajoz", "Barcelona", "Burgos", "Cáceres", "Cádiz", "Cantabria", "Castellón",
                    "Ciudad Real", "Córdoba", "Cuenca", "Gerona", "Granada", "Guadalajara", "Guipúzcoa",
                    "Huelva", "Huesca", "Islas Baleares", "Jaén", "La Coruña", "La Rioja", "Las Palmas",
                    "León", "Lérida", "Lugo", "Madrid", "Málaga", "Murcia", "Navarra", "Orense",
                    "Palencia", "Pontevedra", "Salamanca", "Santa Cruz de Tenerife", "Segovia", "Sevilla",
                    "Soria", "Tarragona", "Teruel", "Toledo", "Valencia", "Valladolid", "Vizcaya",
                    "Zamora", "Zaragoza", "Ceuta", "Melilla"
                ];

                // Detectar país
                $pais = $partes_direccion[$total - 1];
                if (strtolower($pais) !== "españa") {
                    $err_direccion = "La dirección debe estar en España.";
                    $err_extra_formato = "<br>El formato de dirección debe ser: Calle, Ciudad, Provincia, Código Postal, España.";
                } else {
                    // Buscar código postal (última parte numérica de 5 dígitos)
                    $cp = null;
                    foreach (array_reverse($partes_direccion) as $parte) {
                        if (is_numeric($parte) && strlen($parte) == 5) {
                            $cp = $parte;
                            break;
                        }
                    }

                    if (!$cp) {
                        $err_direccion = "El código postal no tiene un formato válido. Debe tener 5 dígitos.";
                        $err_extra_formato = "<br>El formato de dirección debe ser: Calle, Ciudad, Provincia, Código Postal (5 dígitos), País.";
                    } else {
                        // Buscar provincia en el array
                        $provincia = null;
                        $pos_provincia = null;

                        foreach (array_reverse($partes_direccion, true) as $index => $parte) {
                            foreach ($provincias_espana as $prov) {
                                if (stripos($parte, $prov) !== false) {
                                    $provincia = $prov;
                                    $pos_provincia = $index;
                                    break 2;
                                }
                            }
                        }

                        if (!$provincia) {
                            $err_direccion = "No se reconoció una provincia válida de España en la dirección.";
                        } else {
                            // Asignar ciudad como la parte anterior a la provincia
                            if ($pos_provincia > 0) {
                                $ciudad = $partes_direccion[$pos_provincia - 1];
                            } else {
                                $ciudad = "";
                            }

                            $direccion = $tmp_direccion;
                        }
                    }
                }
            }
        }
        


        /* Validación de tipo de combustible */
        if ($tmp_tipo_combustible == "") {
            $err_tipo_combustible = "Debes indicar el tipo de combustible de tu coche";
        } else {
            $lista_combustibles = [
                "gasolina",
                "diesel",
                "hibrido",
                "electrico",
                "glp",
                "gnc"
            ];
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
            $lista_tipos = [
                "berlina",
                "coupe",
                "deportivo",
                "furgoneta",
                "monovolumen",
                "suv",
                "pick-up",
                "roadster",
                "utilitario",
                "familiar",
                "autocaravana"
            ];
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
            $lista_transmision = [
                "manual",
                "automatico"
            ];
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
            $lista_aparcamiento = [
                "calle",
                "garaje",
                "parking"
            ];
            if (!in_array($tmp_tipo_aparcamiento, $lista_aparcamiento)) {
                $err_tipo_aparcamiento = "El tipo de aparcamiento no es válido";
            } else {
                $tipo_aparcamiento = $tmp_tipo_aparcamiento;
            }
        }

        /* Validación de fotos */
        if (!isset($_FILES['img']) || empty($_FILES['img']['name'][0])) {
            $err_imagen = "Debes subir al menos una imagen de tu coche";
            $rutas_imagenes = [];
        } else {
            $tmp_imagen_nombres = $_FILES['img']['name'];
            $tmp_imagen_ubi = $_FILES['img']['tmp_name'];
            $tmp_imagen_tipos = $_FILES['img']['type'];
            $imagen_errores = $_FILES['img']['error'];
            $rutas_imagenes = [];

            for ($i = 0; $i < count($tmp_imagen_nombres); $i++) {
                if ($imagen_errores[$i] === 0 && isset($matricula, $marca)) {
                    $lista_imagenes = ["image/jpeg", "image/png", "image/jpg"];
                    if (!in_array($tmp_imagen_tipos[$i], $lista_imagenes)) {
                        $err_imagen = "El tipo de la imagen " . htmlspecialchars($tmp_imagen_nombres[$i]) . " no es válido";
                        continue;
                    }

                    // Obtener la extensión de la imagen
                    $extension = str_replace("image/", ".", $tmp_imagen_tipos[$i]);

                    // Generar un nuevo nombre de imagen
                    $nuevo_nombre = $marca . "_img" . ($i + 1) . $extension;

                    // Ruta relativa
                    $ruta_relativa = "/clients/img/" . $_SESSION["usuario"]["identificacion"] . "/coche/" . $matricula;
                    $ruta_relativa_con_nombre = $ruta_relativa . "/" . $nuevo_nombre;

                    // Ruta absoluta del sistema
                    $ruta_absoluta = $_SERVER['DOCUMENT_ROOT'] . $ruta_relativa;
                    $ruta_absoluta_con_nombre = $ruta_absoluta . "/" . $nuevo_nombre;

                    // Crear carpeta si no existe
                    if (!is_dir($ruta_absoluta)) {
                        mkdir($ruta_absoluta, 0777, true);
                    }

                    // Mover imagen a la carpeta destino
                    if (move_uploaded_file($tmp_imagen_ubi[$i], $ruta_absoluta_con_nombre)) {
                        $rutas_imagenes[] = $ruta_relativa_con_nombre;
                    } else {
                        $err_imagen = "Error al mover la imagen " . htmlspecialchars($tmp_imagen_nombres[$i]);
                    }
                } else {
                    $err_imagen = "Error en la imagen " . htmlspecialchars($tmp_imagen_nombres[$i]);
                }
            }
        }


        /* Validación de color */
        if ($tmp_color == "") {
            $err_color = "Debes indicar el color de tu coche";
        } else {
            $lista_colores = ["white", "black", "gray", "red", "blue", "green", "yellow", "orange", "brown", "others"];
            if (!in_array($tmp_color, $lista_colores)) {
                $err_color = "El color no es válido";
            } else {
                $tmp_color = strtolower($tmp_color);
                $color = $tmp_color;
            }
        }

        /* Validación de descripción */
        if (strlen($tmp_descripcion) > 200) {
            $err_descripcion = "La descripción no puede tener más de 200 caracteres";
        } else {
            $descripcion = $tmp_descripcion;
        }

        /* Validación de potencia */
        if ($tmp_potencia == "") {
            $err_potencia = "Debes indicar la potencia de tu coche";
        } else {
            if (!is_numeric($tmp_potencia)) {
                $err_potencia = "La potencia debe ser un número";
            } else {
                if ($tmp_potencia < 0) {
                    $err_potencia = "La potencia no puede ser negativa";
                } else {
                    if ($tmp_potencia > 2000) {
                        $err_potencia = "La potencia no puede ser mayor a 2000";
                    } else {
                        $tmp_potencia = str_replace(",", ".", $tmp_potencia);
                        $tmp_potencia = str_replace(".", "", $tmp_potencia);
                        $potencia = $tmp_potencia;
                    }
                }
            }
        }

        /* Validación de número de puertas */
        if ($tmp_numero_puertas == "") {
            $err_numero_puertas = "Debes indicar el número de puertas de tu coche";
        } else {
            if (!is_numeric($tmp_numero_puertas)) {
                $err_numero_puertas = "El número de puertas debe ser un número";
            } else {
                if ($tmp_numero_puertas < 0) {
                    $err_numero_puertas = "El número de puertas no puede ser negativo";
                } else {
                    if ($tmp_numero_puertas > 5) {
                        $err_numero_puertas = "El número de puertas no puede ser mayor a 5";
                    } else {
                        $puertas = $tmp_numero_puertas;
                    }
                }
            }
        }

        /* Validación de número de plazas */
        if ($tmp_numero_plazas == "") {
            $err_numero_plazas = "Debes indicar el número de plazas de tu coche";
        } else {
            if (!is_numeric($tmp_numero_plazas)) {
                $err_numero_plazas = "El número de plazas debe ser un número";
            } else {
                if ($tmp_numero_plazas < 0) {
                    $err_numero_plazas = "El número de plazas no puede ser negativo";
                } else {
                    if ($tmp_numero_plazas > 9) {
                        $err_numero_plazas = "El número de plazas no puede ser mayor a 9";
                    } else {
                        $plazas = $tmp_numero_plazas;
                    }
                }
            }
        }
    }
    ?>

    <?php include_once '../../components/navbar.php'; ?>
    <div>
        <form action="#" id="formulario" method="post" enctype="multipart/form-data">
            <div class="container mt-5 pt-5">
                <div class="card py-4 px-2 px-md-4 p-4">
                    <h3 class="text-start mb-4">Información básica ✍🏼</h3>
                    <div class="row gy-3 justify-content-center p-3">
                    <?php
                    // API para obtener las marcas de coches
                    $apiUrlMarcas = "https://vpic.nhtsa.dot.gov/api/vehicles/GetMakesForVehicleType/car?format=json";

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $apiUrlMarcas);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $respuesta = curl_exec($curl);

                    $marcas = []; // Inicializamos por si falla

                    if (curl_errno($curl)) {
                        // Error de cURL
                        echo "<div class='alert alert-warning'>No se pudo conectar con la API de marcas. Se cargarán marcas de ejemplo.</div>";
                    } else {
                        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                        if ($httpCode === 200) {
                            $datos = json_decode($respuesta, true);
                            if (json_last_error() === JSON_ERROR_NONE && isset($datos['Results'])) {
                                $marcas = $datos['Results'];
                            } else {
                                echo "<div class='alert alert-warning'>La API respondió, pero los datos no son válidos. Se cargarán marcas de ejemplo.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-warning'>La API de marcas está en mantenimiento (HTTP $httpCode). Se cargarán marcas de ejemplo.</div>";
                        }
                    }
                    curl_close($curl);

                    // Si no hay marcas válidas, usar marcas ficticias
                    if (empty($marcas)) {
                        $marcas = [
                            ['MakeId' => 1, 'MakeName' => 'Toyota'],
                            ['MakeId' => 2, 'MakeName' => 'Honda'],
                            ['MakeId' => 3, 'MakeName' => 'Ford'],
                            ['MakeId' => 4, 'MakeName' => 'BMW'],
                            ['MakeId' => 5, 'MakeName' => 'Renault'],
                        ];
                    }

                    $marcaSeleccionada = isset($_POST['marca']) ? $_POST['marca'] : '';
                    $modeloSeleccionado = isset($_POST['modelo']) ? $_POST['modelo'] : '';
                    ?>

                    <!-- Marca -->
                    <div class="col-12 col-md-3">
                        <div class="form-floating">
                            <select class="form-select <?php if (isset($err_marca)) echo 'is-invalid'; ?>" id="marca" name="marca">
                                <option disabled selected hidden>Marca*</option>
                                <?php foreach ($marcas as $marcaItem) { ?>
                                    <option value="<?php echo htmlspecialchars($marcaItem["MakeName"]); ?>"
                                        <?php if ($marcaSeleccionada === $marcaItem["MakeName"]) echo "selected"; ?>>
                                        <?php echo htmlspecialchars($marcaItem["MakeName"]); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <label for="marca">Marca</label>
                            <?php
                            if (isset($err_marca)) {
                                echo "<span class='error'>$err_marca</span>";
                            }
                            ?>
                        </div>
                    </div>

                        <!-- Modelo -->
                        <div class="col-12 col-md-3">
                            <div class="form-floating">
                                <select class="form-select <?php if (isset($err_modelo)) echo 'is-invalid'; ?>" id="modelo" name="modelo" data-selected="<?php echo htmlspecialchars($modeloSeleccionado); ?>">
                                    <option disabled selected hidden>Modelo*</option>
                                </select>
                                <label for="modelo">Modelo</label>
                                <?php
                                if (isset($err_modelo)) {
                                    echo "<span class='error'>$err_modelo</span>";
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Año de matriculación -->
                        <div class="col-12 col-md-3">
                            <div class="form-floating">
                                <input class="form-control <?php if (isset($err_anno_matriculacion)) echo 'is-invalid'; ?>" placeholder="Año de matriculacion" id="inputMes" type="month" name="anno_matriculacion" value="<?php if (isset($_POST['anno_matriculacion'])) echo htmlspecialchars($_POST['anno_matriculacion']); ?>">
                                <label for="inputMes">Año de matriculación</label>
                                <?php
                                if (isset($err_anno_matriculacion)) {
                                    echo "<span class='error'>$err_anno_matriculacion</span>";
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Matrícula -->
                        <div class="col-12 col-md-3">
                            <div class="form-floating">
                                <input class="form-control <?php if (isset($err_matricula)) echo 'is-invalid'; ?>" id="floatingInput" type="text" placeholder="Matricula*" name="matricula" value="<?php if (isset($matricula)) echo htmlspecialchars($matricula); ?>">
                                <label for="floatingInput">Matrícula</label>
                                <?php
                                if (isset($err_matricula)) {
                                    echo "<span class='error'>$err_matricula</span>";
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>





            <div class="container mt-5 pt-5">

                <div class="card py-4 px-2 px-md-4 p-4">
                    <br>
                    <h3>Información del vehículo 🚗</h3>
                    <div class="row justify-content-center pt-3">
                        <div class="mb-3 col-6">
                            <div class="form-floating">
                                <input class="form-control <?php if (isset($err_kilometros)) echo 'is-invalid'; ?>" id="kilometros" type="number" placeholder="Kilómetros*" name="kilometros" value="<?php if (isset($kilometros)) echo "$kilometros" ?>">
                                <label for="kilometros">Kilómetros</label>
                                <?php
                                if (isset($err_kilometros)) {
                                    echo "<span class='error'>$err_kilometros</span>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="mb-3 col-6">
                            <div class="form-floating">
                                <select class="form-select <?php if (isset($err_tipo_combustible)) echo 'is-invalid'; ?>" id="tipo_combustible" name="tipo_combustible">
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
                                        Híbrido
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
                                </select>
                                <label for="tipo_combustible">Tipo de combustible</label>
                                <?php
                                if (isset($err_tipo_combustible)) {
                                    echo "<span class='error'>$err_tipo_combustible</span>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="mb-3 col-6">
                            <div class="form-floating">
                                <select class="form-select <?php if (isset($err_tipo)) echo 'is-invalid'; ?>" id="tipo" name="tipo">
                                    <option disabled selected hidden>Tipo de coche*</option>
                                    <option value="berlina" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "berlina") echo "selected"; ?>>
                                        Berlina
                                    </option>
                                    <option value="coupe" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "coupe") echo "selected"; ?>>
                                        Coupé
                                    </option>
                                    <option value="deportivo" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "deportivo") echo "selected"; ?>>
                                        Deportivo
                                    </option>
                                    <option value="furgoneta" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "furgoneta") echo "selected"; ?>>
                                        Furgoneta
                                    </option>
                                    <option value="monovolumen" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "monovolumen") echo "selected"; ?>>
                                        Monovolumen
                                    </option>
                                    <option value="suv" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "suv") echo "selected"; ?>>
                                        SUV
                                    </option>
                                    <option value="pick-up" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "pick-up") echo "selected"; ?>>
                                        Pick-up
                                    </option>
                                    <option value="roadster" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "roadster") echo "selected"; ?>>
                                        Roadster
                                    </option>
                                    <option value="utilitario" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "utilitario") echo "selected"; ?>>
                                        Utilitario
                                    </option>
                                    <option value="familiar" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "familiar") echo "selected"; ?>>
                                        Familiar
                                    </option>
                                    <option value="autocaravana" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == "autocaravana") echo "selected"; ?>>
                                        Autocaravana
                                    </option>
                                </select>
                                <label for="tipo">Tipo de coche</label>

                                <?php
                                if (isset($err_tipo)) {
                                    echo "<span class='error'>$err_tipo</span>";
                                }
                                ?>
                            </div>
                        </div>


                        <div class="mb-3 col-6">
                            <div class="form-floating">
                                <select class="form-select <?php if (isset($err_transmision)) echo 'is-invalid'; ?>" id="transmision" name="transmision">
                                    <option disabled selected hidden>Transmisión*</option>
                                    <option value="manual" <?php if (isset($_POST['transmision']) && $_POST['transmision'] == "manual") echo "selected"; ?>>
                                        Manual
                                    </option>
                                    <option value="automatico" <?php if (isset($_POST['transmision']) && $_POST['transmision'] == "automatico") echo "selected"; ?>>
                                        Automática
                                    </option>
                                </select>
                                <label for="transmision">Transmisión</label>
                                <?php
                                if (isset($err_transmision)) {
                                    echo "<span class='error'>$err_transmision</span>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="mb-3 col-6">
                            <div class="form-floating">
                                <select class="form-select <?php if (isset($err_color)) echo 'is-invalid'; ?>" id="color" name="color" required>
                                    <option disabled selected hidden>Color*</option>
                                    <option value="white" <?php if (isset($_POST['color']) && $_POST['color'] == "white") echo "selected"; ?>>Blanco</option>
                                    <option value="black" <?php if (isset($_POST['color']) && $_POST['color'] == "black") echo "selected"; ?>>Negro</option>
                                    <option value="gray" <?php if (isset($_POST['color']) && $_POST['color'] == "gray") echo "selected"; ?>>Gris</option>
                                    <option value="red" <?php if (isset($_POST['color']) && $_POST['color'] == "red") echo "selected"; ?>>Rojo</option>
                                    <option value="blue" <?php if (isset($_POST['color']) && $_POST['color'] == "blue") echo "selected"; ?>>Azul</option>
                                    <option value="green" <?php if (isset($_POST['color']) && $_POST['color'] == "green") echo "selected"; ?>>Verde</option>
                                    <option value="yellow" <?php if (isset($_POST['color']) && $_POST['color'] == "yellow") echo "selected"; ?>>Amarillo</option>
                                    <option value="orange" <?php if (isset($_POST['color']) && $_POST['color'] == "orange") echo "selected"; ?>>Naranja</option>
                                    <option value="brown" <?php if (isset($_POST['color']) && $_POST['color'] == "brown") echo "selected"; ?>>Marrón</option>
                                    <option value="others" <?php if (isset($_POST['color']) && $_POST['color'] == "others") echo "selected"; ?>>Otros</option>
                                </select>
                                <label for="color">Color</label>

                                <?php
                                if (isset($err_color)) {
                                    echo "<span class='error'>$err_color</span>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="mb-3 col-6">
                            <div class="form-floating">
                                <input class="form-control <?php if (isset($err_potencia)) echo 'is-invalid'; ?>" min="30" max="2000" id="potencia" type="number" placeholder="Potencia*" name="potencia" value="<?php if (isset($potencia)) echo "$potencia" ?>">
                                <label for="potencia">Potencia</label>
                                <?php
                                if (isset($err_potencia)) {
                                    echo "<span class='error'>$err_potencia</span>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="mb-3 col-6">
                            <div class="form-floating">
                                <input class="form-control <?php if (isset($err_numero_puertas)) echo 'is-invalid'; ?>" min="2" max="5" id="numero_puertas" type="number" placeholder="Numero de puertas*" name="numero_puertas" value="<?php if (isset($puertas)) echo "$puertas" ?>">
                                <label for="numero_puertas">Numero de puertas</label>
                                <?php
                                if (isset($err_numero_puertas)) {
                                    echo "<span class='error'>$err_numero_puertas</span>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="mb-3 col-6">
                            <div class="form-floating">
                                <input class="form-control <?php if (isset($err_numero_plazas)) echo 'is-invalid'; ?>" min="1" max="9" id="numero_plazas" type="number" placeholder="Numero de plazas*" name="numero_plazas" value="<?php if (isset($plazas)) echo "$plazas" ?>">
                                <label for="numero_plazas">Numero de plazas</label>
                                <?php
                                if (isset($err_numero_plazas)) {
                                    echo "<span class='error'>$err_numero_plazas</span>";
                                }
                                ?>
                            </div>
                        </div>

                        <div>
                            <div class="form-floating">
                                <textarea class="form-control <?php if (isset($err_descripcion)) echo 'is-invalid'; ?>" name="descripcion" id="floatingTextarea2" rows="3" style="height: 100px" placeholder="Descripcion*"><?php if (isset($descripcion)) echo "$descripcion"; ?></textarea>
                                <label for="floatingTextarea2">Descripcion</label>
                                <?php
                                if (isset($err_descripcion)) {
                                    echo "<span class='error'>$err_descripcion</span>";
                                }
                                ?>
                                <br>
                            </div>
                        </div>


                    </div>
                </div>
            </div>


            <div class="container mt-5 pt-5">
                <div class="card py-4 px-2 px-md-4 p-4">
                    <h3 class="text-start">Precio por día 💸</h3>

                    <div class="d-flex flex-column align-items-center">
                        <label id="totalPrecio" class="form-label fw-bold">
                            Precio Diario:
                            <span id="mostrarPrecio">
                                <?php if (isset($_POST['precio'])) echo $_POST['precio'] . "€";
                                else echo "15€"; ?>
                            </span>
                        </label>

                        <input type="range" class="form-range w-75 <?php if (isset($err_precio)) echo 'is-invalid'; ?>" name="precio" id="precio" min="15" max="500" step="1" value="<?php if (isset($_POST['precio'])) echo $_POST['precio'];
                                                                                                                                                                                        else echo '15'; ?>">

                        <div class="d-flex justify-content-between text-muted mt-1 w-75">
                            <span>15€</span>
                            <span>500€</span>
                        </div>

                        <?php
                        if (isset($err_precio)) {
                            echo "<span class='error'>$err_precio</span>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Dirección y Tipo de aparcamiento -->
            <div class="container mt-5 pt-5">
                <div class="card py-4 px-2 px-md-4 p-4">
                    <h3 class="text-start">Ubicación del vehículo 📍</h3>
                    <div class="row justify-content-center pt-3">
                        <!-- Dirección -->
                        <div class="mb-3 col-12 col-md-6">
                            <div class="form-floating" style="position: relative;">
                                <input type="text" class="form-control <?php if (isset($err_direccion)) echo 'is-invalid'; ?>" id="autocomplete" name="direccion" placeholder="Ej: Calle Ejemplo, Ciudad, Provincia, Codigo Postal, País" autocomplete="off" value="<?php if (isset($direccion)) echo "$direccion" ?>">
                                <label for="autocomplete" class="form-label">Dirección*</label>
                                <?php
                                if (isset($err_direccion)) {
                                    echo "<span class='error'>$err_direccion</span>";
                                    if (isset($err_extra_formato)) {
                                        echo "<span class='error'>$err_extra_formato</span>";
                                    }
                                }
                                ?>
                                <div id="sugerencias" class="list-group mt-2" style="z-index:1000; position: absolute; width: 100%; max-height: 300px; overflow-y: auto; background-color: white; border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></div>
                            </div>
                        </div>

                        <!-- Tipo de aparcamiento -->
                        <div class="mb-3 col-12 col-md-6">
                            <div class="form-floating">
                                <select class="form-select <?php if (isset($err_tipo_aparcamiento)) echo 'is-invalid'; ?>" id="tipo_aparcamiento" name="tipo_aparcamiento">
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
                                        Parking
                                    </option>
                                </select>
                                <label for="tipo_aparcamiento">Tipo de aparcamiento</label>
                                <?php
                                if (isset($err_tipo_aparcamiento)) {
                                    echo "<span class='error'>$err_tipo_aparcamiento</span>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Coordenadas ocultas -->
                    <input type="hidden" name="lat" id="lat" value="<?php if (isset($lat)) echo "$lat" ?>">
                    <input type="hidden" name="lon" id="lon" value="<?php if (isset($lon)) echo "$lon" ?>">
                </div>
            </div>


            <!-- Imagenes -->
            <div class="container mt-5 pt-5">
                <div class="card py-4 py-4 px-2 px-md-4 p-4">
                    <h3>Imágenes 📸</h3>
                    <div class="row justify-content-center pt-3">
                        <div class="form-floating">
                            <input class="form-control" <?php if (isset($err_imagen)) echo 'is-invalid'; ?>" id="img" type="file" name="img[]" multiple accept="image/png, image/jpg, image/jpeg">
                            <?php
                            if (isset($err_imagen)) {
                                echo "<span class='error'>$err_imagen</span>";
                            }
                            ?>
                        </div>

                    </div>
                    <div id="mostrar_img" class="d-flex flex-wrap gap-2 mt-3"></div>
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





            <div class="row g-2 pt-3">
                <div class="col-12 col-md-6">
                    <button type="button" class="btn btn-primary btn-lg w-100" data-bs-toggle="modal" data-bs-target="#miModal">
                        Extras
                    </button>
                </div>
                <div class="col-12 col-md-6">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        Confirmar
                    </button>
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

                <!-- BOTÓN CERRAR DE LA VENTANA MODAL -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </form>
    <br>
    <?php include_once '../../components/footer-example.php'; ?>
    <script src="../../js/mostrar_marcas.js"></script>
    <script src="../../js/nuevo_coche.js"></script>
    <script src="../../js/pre_imagen.js"></script>
    <script src="../../js/obtener_direccion.js"></script>
    <script src="../../js/precio_coche.js"></script>

    <?php
    if (isset($matricula, $id_usuario, $seguro, $marca, $modelo, $anno_matriculacion, $kilometros, $tipo_combustible, $transmision, $direccion, $tipo_aparcamiento, $ruta_relativa, $tipo, $precio, $descripcion, $color, $plazas, $puertas, $potencia, $lat, $lon, $aire_acondicionado, $gps, $wifi, $sensores_aparcamiento, $camara_trasera, $control_de_crucero, $asientos_calefactables, $bola_remolque, $fijacion_isofix, $apple_carplay, $android_carplay, $baca, $portabicicletas, $portaequipajes, $portaesquis, $bluetooth, $cuatro_x_cuatro, $mascota, $fumar, $movilidad_reducida, $rutas_imagenes)) {
        /* Insertar coche */
        $enviar_coche = $_conexion->prepare("INSERT INTO coche (
            matricula, id_usuario, seguro, marca, modelo, anno_matriculacion, kilometros,
            combustible, transmision, direccion, ciudad, provincia, codigo_postal, pais,
            lat, lon, tipo_aparcamiento, ruta_img_coche, tipo, precio, descripcion, color,
             plazas, puertas, potencia) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$enviar_coche) {
            die('Error en prepare coche: ' . $_conexion->error);
        }

        $enviar_coche->bind_param(
            "ssisssisssssiddisssissiii",
            $matricula,
            $id_usuario,
            $seguro,
            $marca,
            $modelo,
            $anno_matriculacion,
            $kilometros,
            $tipo_combustible,
            $transmision,
            $direccion,
            $ciudad,
            $provincia,
            $cp,
            $pais,
            $lat,
            $lon,
            $tipo_aparcamiento,
            $ruta_relativa,
            $tipo,
            $precio,
            $descripcion,
            $color,
            $plazas,
            $puertas,
            $potencia
        );

        if (!$enviar_coche->execute()) {
            die('Error al insertar coche: ' . $enviar_coche->error);
        }

        /* Insertar los extras */
        $enviarExtras = $_conexion->prepare("INSERT INTO extras_coche (
                matricula, aire_acondicionado, gps, wifi, sensores_aparcamiento, 
                camara_trasera, control_de_crucero, asientos_calefactables, bola_remolque, 
                fijacion_isofix, apple_carplay, android_carplay, baca, portabicicletas, 
                portaequipajes, portaesquis, bluetooth, cuatro_x_cuatro, mascota, fumar, 
                movilidad_reducida
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$enviarExtras) {
            die('Error en prepare extras: ' . $_conexion->error);
        }

        $enviarExtras->bind_param(
            "siiiiiiiiiiiiiiiiiiii",
            $matricula,
            $aire_acondicionado,
            $gps,
            $wifi,
            $sensores_aparcamiento,
            $camara_trasera,
            $control_de_crucero,
            $asientos_calefactables,
            $bola_remolque,
            $fijacion_isofix,
            $apple_carplay,
            $android_carplay,
            $baca,
            $portabicicletas,
            $portaequipajes,
            $portaesquis,
            $bluetooth,
            $cuatro_x_cuatro,
            $mascota,
            $fumar,
            $movilidad_reducida
        );

        if (!$enviarExtras->execute()) {
            die('Error al insertar extras: ' . $enviarExtras->error);
        }

        /* Insertar imagenes */
        $enviarImagenes = $_conexion->prepare("INSERT INTO imagen_coche (id_coche, ruta_img_coche) VALUES (?, ?)");

        if (!$enviarImagenes) {
            die('Error en prepare imagenes: ' . $_conexion->error);
        }

        if (isset($rutas_imagenes) && is_array($rutas_imagenes)) {
            foreach ($rutas_imagenes as $ruta) {
                $enviarImagenes->bind_param("ss", $matricula, $ruta);
                if (!$enviarImagenes->execute()) {
                    die('Error al insertar imagen: ' . $enviarImagenes->error);
                }
            }
        }

        /* Redirigir a la página de inicio */
        echo "<script>
                window.location.href = '/src/pages/rentacar/coche?matricula=" . $matricula . "';
              </script>";
        exit();
    }
    ?>


</body>

</html>