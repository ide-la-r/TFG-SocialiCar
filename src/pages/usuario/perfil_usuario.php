<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    session_start();

    require(__DIR__ . "/../../config/conexion.php");
    require(__DIR__ . "/../../config/depurar.php");

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION["usuario"])) {
        header("location: ../../../index.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si se ha subido una foto de perfil
        if (isset($_FILES["foto_perfil"]) && $_FILES["foto_perfil"]["error"] == 0) {
            $fotoPerfil = $_FILES["foto_perfil"];
            $nombreArchivo = $fotoPerfil["name"];
            $rutaTemporal = $fotoPerfil["tmp_name"];
            $rutaDestino = __DIR__ . "/../../../src/img/perfil/" . $_SESSION["usuario"]["dni"];

            $lista_extensiones = array("image/jpg", "image/jpeg", "image/png", "image/webp");
            if (!in_array($fotoPerfil["type"], $lista_extensiones)) {
                $err_fotoPerfil = "Formato de imagen no válido. Solo se permiten JPG, JPEG, PNG y WEBP.";
            } else {
                // Crear el directorio si no existe
                if (!is_dir($rutaDestino)) {
                    mkdir($rutaDestino, 0777, true);
                }

                // Mover la imagen a la carpeta de destino
                if (move_uploaded_file($rutaTemporal, $rutaDestino . "/" . $nombreArchivo)) {
                    // Actualizar la ruta de la foto de perfil en la base de datos
                    $sql = "UPDATE usuario SET foto_perfil = ? WHERE dni = ?";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("ss", $nombreArchivo, $_SESSION["usuario"]["dni"]);
                    if ($stmt->execute()) {
                        $_SESSION["usuario"]["foto_perfil"] = $nombreArchivo;
                        header("Location: " . $_SERVER["PHP_SELF"]);
                        exit();
                    } else {
                        $err_fotoPerfil = "Error al actualizar la foto de perfil en la base de datos.";
                    }
                } else {
                    $err_fotoPerfil = "Error al mover la imagen a la carpeta de destino.";
                }
            }

        } else {
           $err_fotoPerfil = "Error al subir la foto de perfil.";
        }
    }


?>


<!DOCTYPE html>
<html lang="en">

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
                                <img src="../../../src/img/perfil.png" alt="Imagen del usuario" class="rounded-circle mb-3" width="100" height="100">
                                <h6 class="mb-0">Foto Perfil</h6>
                                <div class="text-center mt-4">
                                    <form action="ruta_a_tu_php.php" method="post" enctype="multipart/form-data" id="formFotoPerfil">
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
                                    <li><strong>Nombre:</strong></li>
                                    <li><strong>Email:</strong></li>
                                    <li><strong>Teléfono:</strong></li>
                                    <!-- Añade más datos si lo deseas -->
                                </ul>
                                <div class="text-center mt-4">
                                    <a href="/socialicar/src/pages/usuario/editar_usuario" class="btn btn-outline-primary btn-sm">Cambiar credenciales</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- TUS VEHICULOS -->
                    <div class="row">
                        <div class="col-12">
                            <div class="bg-light rounded-4 shadow-sm p-4">
                                <h5 class="mb-3"><i class="fas fa-car me-2"></i>Tus vehículos</h5>
                                <div class="text-center text-muted py-4">
                                    <!-- LISTA DE VEHICULOS -->
                                    <i class="fas fa-car-side fa-2x mb-2"></i>
                                    <p class="mb-0">Aún no has registrado vehículos.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once '../../components/footer.php'; ?>
</body>

</html>