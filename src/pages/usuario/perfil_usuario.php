<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    session_start();

    require(__DIR__ . "/../../config/conexion.php");
    require(__DIR__ . "/../../config/depurar.php");

    // Verificar si la conexión está funcionando correctamente
    if (!$_conexion) {
        echo "Error en la conexión a la base de datos.";
        exit();
    }

    if (!isset($_SESSION["usuario"])) {
        header("location: ../../../index.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES["foto_perfil"]) && $_FILES["foto_perfil"]["error"] == 0) {
            $fotoPerfil = $_FILES["foto_perfil"];
            $nombreArchivo = $fotoPerfil["name"];
            $rutaTemporal = $fotoPerfil["tmp_name"];
            $dniUsuario = $_SESSION["usuario"]["dni"];
            $rutaDestino = __DIR__ . "/../../../../public/img/perfil/" . $dniUsuario;

            // Depuración: Verificar la ruta de destino
            echo "Ruta destino: " . $rutaDestino . "<br>";

            // Verificar las extensiones permitidas
            $lista_extensiones = ["image/jpg", "image/jpeg", "image/png", "image/webp"];
            if (!in_array($fotoPerfil["type"], $lista_extensiones)) {
                $err_fotoPerfil = "Formato de imagen no válido. Solo se permiten JPG, JPEG, PNG y WEBP.";
            } else {
                // Crear la carpeta si no existe
                if (!is_dir($rutaDestino)) {
                    echo "Creando carpeta: " . $rutaDestino . "<br>";
                    if (mkdir($rutaDestino, 0777, true)) {
                        echo "Carpeta creada correctamente: " . $rutaDestino . "<br>";
                    } else {
                        echo "No se pudo crear la carpeta: " . $rutaDestino . "<br>";
                    }
                }

                // Mover la imagen a la carpeta del usuario
                if (move_uploaded_file($rutaTemporal, $rutaDestino . "/" . $nombreArchivo)) {
                    $rutaRelativaBD = "public/img/perfil/" . $dniUsuario . "/" . $nombreArchivo;

                    // Actualizar la base de datos
                    $sql = "UPDATE usuario SET foto_perfil = ? WHERE identificacion = ?";
                    $stmt = $_conexion->prepare($sql);
                    $stmt->bind_param("ss", $rutaRelativaBD, $dniUsuario);

                    if ($stmt->execute()) {
                        $_SESSION["usuario"]["foto_perfil"] = $rutaRelativaBD;
                        header("Location: " . $_SERVER["PHP_SELF"]);
                        exit();
                    } else {
                        $err_fotoPerfil = "Error al actualizar la foto en la base de datos.";
                    }
                } else {
                    $err_fotoPerfil = "Error al mover la imagen.";
                }
            }
        } else {
            $err_fotoPerfil = "No se ha seleccionado una imagen válida.";
        }
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de usuario</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
</head>
<body>
    <?php include_once '../../components/navbar.php'; ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow rounded-4 p-4">
                    <div class="row g-4 mb-4">
                        <!-- FOTO DE PERFIL -->
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <div class="bg-light rounded-4 shadow-sm p-4 w-100 text-center">
                                <?php
                                    $stmt = $_conexion->prepare("SELECT foto_perfil FROM usuario WHERE identificacion = ?");
                                    $stmt->bind_param("s", $_SESSION["usuario"]["dni"]);
                                    $stmt->execute();
                                    $resultado = $stmt->get_result();

                                    if ($resultado->num_rows > 0) {
                                        $usuario = $resultado->fetch_assoc();
                                        $rutaFotoPerfil = $usuario["foto_perfil"];
                                        if ($rutaFotoPerfil) {
                                            echo "<img src='../../../$rutaFotoPerfil' alt='Imagen del usuario' class='rounded-circle mb-3' width='100' height='100'>";
                                        } else {
                                            echo "<img src='../../../src/img/perfil.png' alt='Imagen del usuario' class='rounded-circle mb-3' width='100' height='100'>";
                                        }
                                    }
                                ?>
                                <h6 class="mb-0">Foto Perfil</h6>
                                <div class="text-center mt-4">
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="formFotoPerfil">
                                        <label for="foto_perfil" class="btn btn-outline-success fw-bold me-3 mb-0" style="border-radius: 2rem; cursor:pointer;">
                                            Subir foto
                                        </label>
                                        <input type="file" id="foto_perfil" name="foto_perfil"
                                               accept="image/jpg, image/jpeg, image/png, image/webp"
                                               style="display:none;" onchange="document.getElementById('formFotoPerfil').submit();">
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- DATOS PERSONALES -->
                        <div class="col-md-8">
                            <div class="bg-light rounded-4 shadow-sm p-4 h-100">
                                <div class="mb-3">
                                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Datos personales</h5>
                                </div>
                                <ul class="list-unstyled mb-0">
                                    <li><strong>Nombre:</strong> <?php echo $_SESSION["usuario"]["nombre"] . " " . $_SESSION["usuario"]["apellido"]; ?></li>
                                    <li><strong>Email:</strong> <?php echo $_SESSION["usuario"]["correo"]; ?></li>
                                    <li><strong>Teléfono:</strong> <?php echo $_SESSION["usuario"]["telefono"]; ?></li>
                                </ul>
                                <div class="text-center mt-4">
                                    <a href="/src/pages/usuario/editar_usuario" class="btn btn-outline-primary btn-sm">Editar datos</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TUS VEHÍCULOS -->
                    <div class="row">
                        <div class="col-12">
                            <?php
                                // Verificar si el usuario tiene vehículos registrados
                                $usuario = $_SESSION["usuario"]["identificacion"];
                                $obtener_coche = $_conexion->prepare("SELECT * FROM coche WHERE id_usuario = ?");
                                $obtener_coche->bind_param("s", $usuario);
                                $obtener_coche->execute();
                                $resultado = $obtener_coche->get_result();
                                $vehiculos = $resultado->fetch_all(MYSQLI_ASSOC);

                                if (count($vehiculos) === 0) {
                                    echo "
                                    <div class='bg-light rounded-4 shadow-sm p-4'>
                                        <h5 class='mb-3'><i class='fas fa-car me-2'></i>Tus vehículos</h5>
                                        <div class='text-center text-muted py-4'>
                                            <i class='fas fa-car-side fa-2x mb-2'></i>
                                            <p class='mb-0'>Aún no has registrado vehículos.</p>
                                        </div>
                                    </div>
                                    ";
                                } else {
                                // Función para formatear la fecha en español
                                function formatearFecha($fecha, $meses) {
                                    $dia = $fecha->format('d');
                                    $mes = $meses[$fecha->format('m')];
                                    $anio = $fecha->format('Y');
                                    return "$dia de $mes de $anio";
                                }

                                // Array de meses
                                $meses = [
                                    '01' => 'enero', '02' => 'febrero', '03' => 'marzo',
                                    '04' => 'abril', '05' => 'mayo', '06' => 'junio',
                                    '07' => 'julio', '08' => 'agosto', '09' => 'septiembre',
                                    '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre'
                                ];

                                // Mostrar los vehículos registrados
                                echo "<div class='bg-light rounded-4 shadow-sm p-4'>";
                                foreach ($vehiculos as $vehiculo) {
                                    $fechaRegistro = new DateTime($vehiculo['created_at']);
                                    $fechaActualizacion = new DateTime($vehiculo['updated_at']);
                                    $fechaMatriculacion = new DateTime($vehiculo['anno_matriculacion']);

                                    // Formatear fechas
                                    $fechaRegistroFormateada = formatearFecha($fechaRegistro, $meses);
                                    $fechaActualizacionFormateada = formatearFecha($fechaActualizacion, $meses);
                                    $mes = $meses[$fechaMatriculacion->format('m')];
                                    $anio = $fechaMatriculacion->format('Y');
                                    $fechaMatriculacionFormateada = "$mes de $anio";

                                    echo "
                                        <div class='card mb-3'>
                                            <div class='card-body'>
                                                <h5 class='card-title'>" . $vehiculo['marca'] . " " . $vehiculo['modelo'] . "</h5>
                                                <p class='card-text'>Fecha matriculación: " . ucfirst($fechaMatriculacionFormateada) . "</p>
                                                <p class='card-text'>Matrícula: " . $vehiculo['matricula'] . "</p>
                                                <p class='card-text'>Kilometraje: " . $vehiculo['kilometros'] . "</p>
                                                <p class='card-text'>Tipo: " . ucfirst($vehiculo['tipo']) . "</p>
                                                <p class='card-text'>Fecha de registro: " . $fechaRegistroFormateada . "</p>
                                                <p class='card-text'>Última actualización: " . $fechaActualizacionFormateada . "</p>
                                                <a href='../coche/editar_coche?matricula=" . $vehiculo['matricula'] . "' class='btn btn-primary me-2'>Editar</a>
                                                <a href='../coche/eliminar_coche?matricula=" . $vehiculo['matricula'] . "' class='btn btn-danger'>Eliminar</a>
                                            </div>
                                        </div>
                                    ";
                                }
                                echo "</div>";                           
                                }
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once '../../components/footer.php'; ?>
</body>
</html>
