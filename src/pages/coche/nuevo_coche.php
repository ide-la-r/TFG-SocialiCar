<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require(__DIR__ . "/../../config/conexion.php");
require(__DIR__ . "/../../config/depurar.php");

session_start();
if (!isset($_SESSION["usuario"])) {
    header("location: ../../../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tmp_matricula = $_POST['matricula'];
    $tmp_marca = $_POST['marca'];
    $tmp_modelo = $_POST['modelo'];
    $tmp_anno_matriculacion = $_POST['anno_matriculacion'];
    $tmp_kilometros = $_POST['kilometros'];
    $tmp_direccion = $_POST['direccion'];
    $tmp_cp = $_POST['cp'];
    $tmp_provincia = $_POST['provincia'];
    $tmp_ciudad = $_POST['ciudad'];
    $tmp_tipo_combustible = $_POST['tipo_combustible'];
    $tmp_transmision = $_POST['transmision'];
    $tmp_tipo_aparcamiento = $_POST['tipo_aparcamiento'];
    $tmp_tipo = $_POST['tipo'];

    $id_usuario = $_SESSION["usuario"];
    $seguro = isset($_POST['seguro']) ? 1 : 0;
    $mascota = isset($_POST['mascota']) ? 1 : 0;
    $fumar = isset($_POST['fumar']) ? 1 : 0;
    $ruta_img_coche = $_POST['ruta_img_coche'] ?? NULL;
    $movilidadreducia = isset($_POST['movilidadreducia']) ? 1 : 0;
    $gps = isset($_POST['gps']) ? 1 : 0;
    $wifi = isset($_POST['wifi']) ? 1 : 0;
    $sensoresaparcamiento = isset($_POST['sensoresaparcamiento']) ? 1 : 0;
    $camaradereversa = isset($_POST['camaradereversa']) ? 1 : 0;
    $controldecrucero = isset($_POST['controldecrucero']) ? 1 : 0;
    $asientoscalefactables = isset($_POST['asientoscalefactables']) ? 1 : 0;
    $bola_remolque = isset($_POST['bola_remolque']) ? 1 : 0;
    $fijaciones_isofix = isset($_POST['fijaciones_isofix']) ? 1 : 0;
    $apple_carplay = isset($_POST['apple_carplay']) ? 1 : 0;
    $android_carplay = isset($_POST['android_carplay']) ? 1 : 0;
    $baca = isset($_POST['baca']) ? 1 : 0;
    $portabicicletas = isset($_POST['portabicicletas']) ? 1 : 0;
    $portaequipajes = isset($_POST['portaequipajes']) ? 1 : 0;
    $portaesquis = isset($_POST['portaesquis']) ? 1 : 0;
    $bluetooth = isset($_POST['bluetooth']) ? 1 : 0;
    $cuatroxcuatro = isset($_POST['cuatroxcuatro']) ? 1 : 0;


    /* Validación de matricula */
    if ($tmp_matricula == "") {
        $err_matricula = "Debes indicar la matricula de tu coche";
    } else {
        $sql = "SELECT * FROM coches WHERE matricula = '$tmp_matricula'";
        $resultado = $_conexion->query($sql);
        if ($resultado -> num_rows == 1) {
            $err_matricula = "Ya existe un coche con esta matricula";
        } else {
            if (strlen($tmp_matricula) > 7) {
                $err_matricula = "La matricula no puede tener más de 7 caracteres";
            } else {
                if (!preg_match("/^[0-9]{4}[A-Z]{3}$/", $tmp_matricula)) {
                    $err_matricula = "La matricula no es válida";
                } else {
                    $matricula = $tmp_matricula;
                }
            }
        }
    }

    /* Validación de marca */
    if ($tmp_marca == "") {
        $err_marca = "Debes indicar la marca de tu coche";
    } else {
        if (strlen($tmp_marca) > 20) {
            $err_marca = "La marca no puede tener más de 20 caracteres";
        } else {
            $marca = $tmp_marca; /* Agregar más adelante la comprovación con la API de las marcas */
        }
    }

    /* Validación de modelo */
    if ($tmp_modelo == "") {
        $err_modelo = "Debes indicar el modelo de tu coche";
    } else {
        if (strlen($tmp_modelo) > 20) {
            $err_modelo = "El modelo no puede tener más de 20 caracteres";
        } else {
            $modelo = $tmp_modelo; /* Agregar más adelante la comprovación con la API de los modelos */
        }
    }

    /* Validación de año de matriculación */
    if ($tmp_anno_matriculacion == "") {
        $err_anno_matriculacion = "Debes indicar el año de matriculación de tu coche";
    } else {
        $anno_matriculacion = $tmp_anno_matriculacion . "-01";
    }

    /* Validación de kilómetros */
    if ($tmp_kilometros == "") {
        $err_kilometros = "Debes indicar los kilómetros de tu coche";
    } else {
        if (!is_numeric($tmp_kilometros)) {
            $err_kilometros = "Los kilómetros deben ser un número";
        } else {
            $kilometros = $tmp_kilometros;
        }
    }

    /* Validación de dirección */
    if ($tmp_direccion == "") {
        $err_direccion = "Debes indicar la dirección de tu coche";
    } else {
        if (strlen($tmp_direccion) > 50) {
            $err_direccion = "La dirección no puede tener más de 50 caracteres";
        } else {
            $direccion = $tmp_direccion;
        }
    }
    
    /* Validación de código postal */
    if ($tmp_cp == "") {
        $err_cp = "Debes indicar el código postal de tu coche";
    } else {
        if (!is_numeric($tmp_cp)) {
            $err_cp = "El código postal debe ser un número";
        } else {
            if (strlen($tmp_cp) != 5) {
                $err_cp = "El código postal debe tener 5 dígitos";
            } else {
                $cp = $tmp_cp;
            }
        }
    }

    /* Validación de provincia */
    if ($tmp_provincia == "") {
        $err_provincia = "Debes indicar la provincia de tu coche";
    } else {
        if (strlen($tmp_provincia) > 20) {
            $err_provincia = "La provincia no puede tener más de 20 caracteres";
        } else {
            $provincia = $tmp_provincia; /* Agregar más adelante la comprovación con la API de las provincias */
        }
    }

    /* Validación de ciudad */
    if ($tmp_ciudad == "") {
        $err_ciudad = "Debes indicar la ciudad de tu coche";
    } else {
        if (strlen($tmp_ciudad) > 20) {
            $err_ciudad = "La ciudad no puede tener más de 20 caracteres";
        } else {
            $ciudad = $tmp_ciudad; /* Agregar más adelante la comprovación con la API de las ciudades */
        }
    }

    /* Validación de tipo de combustible */
    if ($tmp_tipo_combustible == "") {
        $err_tipo_combustible = "Debes indicar el tipo de combustible de tu coche";
    } else {
        $lista_combustibles = ["gasolina", "diesel", "hibrido", "electrico", "glp", "gnc"];
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
        $lista_tipos = ["coupe", "monovolumen", "suv", "familiar", "furgoneta", "utilitario", "autocaravana"];
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
        $lista_transmision = ["manual", "automatico"];
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
        $lista_aparcamiento = ["calle", "garaje", "parking"];
        if (!in_array($tmp_tipo_aparcamiento, $lista_aparcamiento)) {
            $err_tipo_aparcamiento = "El tipo de aparcamiento no es válido";
        } else {
            $tipo_aparcamiento = $tmp_tipo_aparcamiento;
        }
    }

    /* Validación de fotos */
    if (isset($_FILES['fotosCoche'])) {
        $fotosCoche = $_FILES['fotosCoche'];
        $errores = [];
        foreach ($fotosCoche['error'] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $fotosCoche['tmp_name'][$key];
                $name = basename($fotosCoche['name'][$key]);
                move_uploaded_file($tmp_name, "uploads/$name");
            } else {
                $errores[] = "Error al subir la foto: " . $error;
            }
        }
    } else {
        $err_fotosCoche = "Debes subir al menos una foto de tu coche";
    }

}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <?php
        
    ?>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>

    <?php include_once '../../components/navbar.php'; ?>
    <form action="#" method="post">
        <div class="container card text-center card_registro" style="width: 40rem;">
            <h1 class="register">Añadir coche</h1>

            <form action="" class="form-floating">
                <div class="row justify-content-center">
                    <div class="mb-3 col-4">
                        <input class="form-control" type="text" placeholder="Matricula*" name="matricula">
                    </div>
                    <div class="mb-3 col-4">
                        <input class="form-control" type="text" placeholder="Marca*" name="marca">
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="mb-3 col-8">
                        <input class="form-control" type="text" placeholder="Modelo*" name="modelo">
                    </div>

                    <div class="mb-3 col-8">
                        <input id="contrasena" class="form-control" type="month" placeholder="Año de matriculación*" name="anno_matriculacion">
                    </div>

                    <div class="mb-3 col-8">
                        <input id="validarContrasena" class="form-control" type="number" placeholder="Kilómetros*" name="kilometros">
                    </div>

                    <div class="mb-3 col-8">
                        <input class="form-control" type="text" placeholder="Direccion*" name="direccion">
                    </div>
                    <div class="mb-3 col-8">
                        <input class="form-control" type="number" placeholder="Código Postal*" name="cp">
                    </div>
                    <div class="mb-3 col-8">
                        <input class="form-control" type="text" placeholder="Provincia*" name="provincia">
                    </div>
                    <div class="mb-3 col-8">
                        <input class="form-control" type="text" placeholder="Ciudad*" name="ciudad">
                    </div>
                    

                    <div class="mb-3 col-8">
                        <Select id="tipoIdentificacion" class="form-select">
                            <option disabled selected hidden>Tipo de combustible*</option>
                            <option value="gasolina">Gasolina</option>
                            <option value="diesel">Diesel</option>
                            <option value="hibrido">Hibrido</option>
                            <option value="electrico">Eléctrico</option>
                            <option value="glp">GLP</option>
                            <option value="gnc">GNC</option>
                        </Select>
                    </div>

                    <div class="mb-3 col-8">
                        <label class="form-label">Tipo de Coche:</label>
                        <select class="form-select">
                            <option selected>- - Selecciona un tipo - -</option>
                            <option value="berlina">Berlina</option>
                            <option value="coupe">Coupé</option>
                            <option value="monovolumen">Monovolumen</option>
                            <option value="suv">SUV</option>
                            <option value="familiar">Familiar</option>
                            <option value="furgoneta">Furgoneta</option>
                            <option value="utilitario">Utilitario</option>
                            <option value="autocaravana">Autocaravana</option>
                        </select>
                    </div>

                    <div class="mb-3 col-8">
                        <Select id="tipoIdentificacion" class="form-select">
                            <option disabled selected hidden>Transmisión*</option>
                            <option value="manual">Manual</option>
                            <option value="automatico">Automática</option>
                        </Select>
                    </div>


                    <div class="mb-3 col-8">
                        <Select id="tipoIdentificacion" class="form-select">
                            <option disabled selected hidden>Tipo de aparcamiento*</option>
                            <option value="calle">Calle </option>
                            <option value="garaje">Garaje</option>
                            <option value="parking">Parking</option>
                        </Select>
                    </div>

                    <!-- INICIO SECCION DE IMAGENES -->
                    <div class="mb-4">
                        <label class="form-label fw-bold fs-4 mb-2 text-start" style="display:block">Fotos</label>
                        <div class="border rounded-3 p-3 mb-3 bg-white" style="border-style: dashed; border-width: 2px;">
                            <div class="d-flex align-items-center mb-1">
                                <label for="fotosCoche" class="btn btn-outline-success fw-bold me-3 mb-0" style="border-radius: 2rem; cursor:pointer;">Subir fotos</label>
                                <input type="file" id="fotosCoche" name="fotosCoche[]" accept="image/jpg, image/jpeg, image/png, image/webp" multiple style="display:none;" aria-label="Subir fotos del coche">
                                <div>
                                    <span class="fw-semibold">Arrastra tus fotos aquí</span><br>
                                    <span class="text-muted" style="font-size: 0.95em;">Formatos aceptados: JPG, JPEG, PNG y WebP. Tamaño límite: 10 MB por archivo.</span>
                                </div>
                            </div>
                        </div>
                        <div class="row row-cols-5 g-3 justify-content-center">
                            <!-- CAJAS IMAGENES DE LOS COCHES -->
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded-3 bg-white d-flex align-items-center justify-content-center" style="height: 110px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#5b7684" stroke-width="2" viewBox="0 0 24 24">
                                        <rect width="18" height="14" x="3" y="5" rx="2" />
                                        <circle cx="8.5" cy="11.5" r="2.5" />
                                        <path d="M21 19 16.65 13.92a2 2 0 0 0-3.3 0L9.5 17.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FIN SECCION DE IMAGENES -->

                    <div class="mb-3 col-8">
                        <input class="form-control" placeholder="" id="identificacion" type="text" hidden>
                    </div>
                </div>
                <!--BOTON VENTANA MODAL CON BOOTSTRAP-->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">
                    Extras
                </button>
            </form>
            <!--BOTON PARA ENVIAR EL FORMULARIO -->
            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">
                Confirmar
            </button>
        </div>
        </div>

        <!-- VENTANA MODAL CON BOOTSTRAP -->
        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="miModalLabel">Seleciona los extras</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group checkbox-group row">
                            <label class="col-6"><input type="checkbox" name="aire_acondicionado"> Aire acondicionado</label>
                            <label class="col-6"><input type="checkbox" name="gps"> GPS</label>
                            <label class="col-6"><input type="checkbox" name="wifi"> Wifi</label>
                            <label class="col-6"><input type="checkbox" name="sensoresaparcamiento"> Sensores de aparcamiento</label>
                            <label class="col-6"><input type="checkbox" name="4x4"> 4x4</label>
                            <label class="col-6"><input type="checkbox" name="camaradereversa"> Cámara de reversa</label>
                            <label class="col-6"><input type="checkbox" name="controldecrucero"> Control de crucero</label>
                            <label class="col-6"><input type="checkbox" name="asientoscalefactables"> Asientos calefactables</label>
                            <label class="col-6"><input type="checkbox" name="mascota"> Mascota permitida</label>
                            <label class="col-6"><input type="checkbox" name="fumar"> Se permite fumar</label>
                            <label class="col-6"><input type="checkbox" name="movilidadreducia"> Movilidad reducida</label>
                            <label class="col-6"><input type="checkbox" name="bola_remolque"> Bola de remolque</label>
                            <label class="col-6"><input type="checkbox" name="fijaciones_isofix"> Fijaciones ISOFIX</label>
                            <label class="col-6"><input type="checkbox" name="android_carplay"> Android CarPlay</label>
                            <label class="col-6"><input type="checkbox" name="apple_carplay"> Apple CarPlay</label>
                            <label class="col-6"><input type="checkbox" name="baca"> Baca</label>
                            <label class="col-6"><input type="checkbox" name="portabicicletas"> Portabicicletas</label>
                            <label class="col-6"><input type="checkbox" name="portaequipajes"> Portaequipajes</label>
                            <label class="col-6"><input type="checkbox" name="portaesquis"> Portaesquís</label>
                            <label class="col-6"><input type="checkbox" name="bluetooth"> Bluetooth</label>
                        </div>
                    </div>


                    <!--BOTON CERRAR DE LA VENTANA MODAL-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
        if (isset($matricula) && isset($marca) && isset($modelo) && isset($anno_matriculacion) && isset($kilometros) && isset($direccion) && isset($cp) && isset($provincia) && isset($ciudad) && isset($tipo_combustible) && isset($transmision) && isset($tipo_aparcamiento)) {
            $enviar = $_conexion->prepare("INSERT INTO coche (
                matricula, id_usuario, seguro, marca, modelo, anno_matriculacion, kilometros,
                combustible, transmision, provincia, ciudad, codigo_postal, direccion,
                tipo_aparcamiento, mascota, fumar, ruta_img_coche, movilidadreducia, gps,
                wifi, sensoresaparcamiento, camaradereversa, controldecrucero,
                asientoscalefactables, bola_remolque, fijaciones_isofix, apple_carplay,
                android_carplay, baca, portabicicletas, portaequipajes, portaesquis,
                bluetooth, `4x4`, tipo
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
            $enviar->bind_param(
                "ssississssssssssiiiiiiiiiiiiiiiiiiis",
                $matricula, $id_usuario, $seguro, $marca, $modelo, $anno_matriculacion, $kilometros,
                $tipo_combustible, $transmision, $provincia, $ciudad, $cp, $direccion,
                $tipo_aparcamiento, $mascota, $fumar, $ruta_img_coche, $movilidadreducia, $gps,
                $wifi, $sensoresaparcamiento, $camaradereversa, $controldecrucero,
                $asientoscalefactables, $bola_remolque, $fijaciones_isofix, $apple_carplay,
                $android_carplay, $baca, $portabicicletas, $portaequipajes, $portaesquis,
                $bluetooth, $cuatroxcuatro, $tipo
            );
        
            $enviar->execute();
        }
    ?>


    <?php include_once '../../components/footer.php'; ?>

</body>

</html>