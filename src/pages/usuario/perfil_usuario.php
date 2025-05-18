<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

require(__DIR__ . "/../../config/conexion.php");
require(__DIR__ . "/../../config/depurar.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../../");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_SESSION["usuario"]["nombre"];
    $identificacion = $_SESSION["usuario"]["identificacion"];

    if (!isset($_FILES['img_perfil']) || $_FILES['img_perfil']['error'] !== 0) {
        $err_imagen_perfil = "Debes subir una imagen válida.";
    } else {
        $tipo = $_FILES['img_perfil']['type'];
        $nombre_original = $_FILES['img_perfil']['name'];
        $temporal = $_FILES['img_perfil']['tmp_name'];

        $extensiones_permitidas = ["image/jpeg", "image/png", "image/jpg", "image/webp"];

        if (!in_array($tipo, $extensiones_permitidas)) {
            $err_imagen_perfil = "El tipo de imagen no es válido.";
        } else {
            $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
            $nuevo_nombre = "img_perfil." . $extension;
            $ruta_relativa = "/clients/img/" . $identificacion . "/perfil";
            $ruta_absoluta = $_SERVER['DOCUMENT_ROOT'] . $ruta_relativa;

            if (!is_dir($ruta_absoluta)) {
                mkdir($ruta_absoluta, 0777, true);
            }

            $ruta_final = $ruta_absoluta . "/" . $nuevo_nombre;
            $ruta_relativa_final = $ruta_relativa . "/" . $nuevo_nombre;

            if (move_uploaded_file($temporal, $ruta_final)) {
                $ruta_bbdd = $ruta_relativa . "/" . $nuevo_nombre;

                $sql = $_conexion->prepare("UPDATE usuario SET foto_perfil = ? WHERE identificacion = ?");
                $sql->bind_param("ss", $ruta_bbdd, $identificacion);
                $sql->execute();
            } else {
                $err_imagen_perfil = "No se pudo guardar la imagen.";
            }
        }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<style>
    body {
        background-image: url('../../img/fondo_perfil.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        margin: 0;
    }
</style>
<body>
    <?php include_once '../../components/navbar.php'; ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow rounded-4 p-4">
                    <div class="row g-4 mb-4">
                        <!-- FOTO DE PERFIL -->
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <div class="container card py-4">
                                <h3 class="text-center">Foto Perfil</h3>
                                <div class="row justify-content-center pt-3">
                                    <div class="col-auto text-center">
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="formFotoPerfil" class="d-flex flex-column align-items-center">
                                            <div class="d-flex flex-column align-items-center mb-3 position-relative" style="padding-top: 50px;">
                                                <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; border: 4px solid #6BBFBF; background-color: #F2F2F2; position: absolute; top: 0;">
                                                    <?php
                                                    $img_sql = $_conexion->prepare("SELECT foto_perfil FROM usuario WHERE identificacion = ?");
                                                    $img_sql->bind_param("s", $_SESSION['usuario']['identificacion']);
                                                    $img_sql->execute();
                                                    $resultado = $img_sql->get_result();
                                                    $fila = $resultado->fetch_assoc();
                                                    echo '<img id="preview_perfil" src="' . (!empty($fila['foto_perfil']) ? htmlspecialchars($fila['foto_perfil']) : '/src/img/perfil.png') . '" alt="Foto de perfil" style="width: 100%; height: 100%; object-fit: cover;">';
                                                    ?>
                                                </div>
                                                <div style="height: 100px;"></div>
                                                <label for="img" class="btn btn-outline-success fw-bold" style="border-radius: 2rem; cursor:pointer;">Subir foto</label>
                                                <input class="form-control <?php if (isset($err_imagen_perfil)) echo 'is-invalid'; ?>" id="img" type="file" name="img_perfil" accept="image/png, image/jpg, image/jpeg, image/webp" style="display:none;" onchange="mostrarImagen(this);">
                                            </div>
                                            <?php if (isset($err_imagen_perfil)) echo "<span class='error'>$err_imagen_perfil</span>"; ?>
                                            <div id="botones_accion" class="d-none flex-column align-items-center mt-3">
                                                <button type="submit" form="formFotoPerfil" class="btn btn-primary mb-2" style="border-radius: 2rem;">Guardar</button>
                                                <button type="button" class="btn btn-danger" style="border-radius: 2rem;" onclick="borrarImagen();">Borrar</button>
                                            </div>
                                        </form>
                                    </div>
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
                                    <?php
                                    $sql = $_conexion->prepare("SELECT * FROM usuario WHERE identificacion = ?");
                                    $sql->bind_param("s", $_SESSION['usuario']['identificacion']);
                                    $sql->execute();
                                    $resultado = $sql->get_result();
                                    if ($resultado->num_rows > 0) {
                                        $fila = $resultado->fetch_assoc();
                                        echo "<li><strong>Nombre:</strong> {$fila['nombre']} {$fila['apellido']}</li>";
                                        echo "<li><strong>Email:</strong> {$fila['correo']}</li>";
                                        echo "<li><strong>Teléfono:</strong> {$fila['telefono']}</li>";
                                    }
                                    ?>
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
                        <div class='accordion' id='accordionVehiculos'>
    <div class='accordion-item'>
        <h2 class='accordion-header'>
            <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#vehiculosCollapse' aria-expanded='false'>
                Mis coches
            </button>
        </h2>
        <div id='vehiculosCollapse' class='accordion-collapse collapse'>
            <div class='accordion-body'>
                <div class='row row-cols-1 row-cols-md-3 g-4'>
                    <?php
                    $usuario = $_SESSION["usuario"]["identificacion"];
                    $obtener_coche = $_conexion->prepare("SELECT * FROM coche WHERE id_usuario = ?");
                    $obtener_coche->bind_param("s", $usuario);
                    $obtener_coche->execute();
                    $resultado = $obtener_coche->get_result();
                    $vehiculos = $resultado->fetch_all(MYSQLI_ASSOC);

                    foreach ($vehiculos as $vehiculo):
                        $stmt_img = $_conexion->prepare("SELECT ruta_img_coche FROM imagen_coche WHERE id_coche = ? LIMIT 1");
                        $stmt_img->bind_param("s", $vehiculo['matricula']);
                        $stmt_img->execute();
                        $res_img = $stmt_img->get_result();
                        $imagen = $res_img->num_rows > 0 ? $res_img->fetch_assoc()['ruta_img_coche'] : '/src/img/default-car.jpg';
                    ?>
                        <div class='col'>
                            <div class='card shadow-sm h-100'>
                                <img src='<?php echo htmlspecialchars($imagen); ?>' class='card-img-top' style='height: 200px; object-fit: cover;'>
                                <div class='card-body text-center'>
                                    <h5 class='card-title mb-1'><?php echo htmlspecialchars($vehiculo['marca']); ?></h5>
                                    <p class='card-text'><?php echo htmlspecialchars($vehiculo['modelo']); ?></p>
                                    <div class='d-flex justify-content-center gap-2 mt-3'>
                                        <form action='/src/pages/coche/editar_coche' method='GET'>
                                            <input type='hidden' name='matricula' value='<?php echo htmlspecialchars($vehiculo['matricula']); ?>'>
                                            <button type='submit'
                                                    class='btn btn-sm fw-bold text-white'
                                                    style='background-color: #0d6efd; border-radius: 20px; padding: 6px 14px; transition: background-color 0.3s;'>
                                                <i class='fas fa-edit me-1'></i> Editar
                                            </button>
                                        </form>
                                        <form action='/src/pages/coche/eliminar_coche?matricula=<?php echo urlencode($vehiculo['matricula']); ?>'
                                            method='POST'
                                            onsubmit="return confirm('¿Estás seguro de eliminar este coche?');">
                                            <input type='hidden' name='matricula' value='<?php echo htmlspecialchars($vehiculo['matricula']); ?>'>
                                            <button type='submit'
                                                    class='btn btn-sm fw-bold text-white'
                                                    style='background-color: #dc3545; border-radius: 20px; padding: 6px 14px; transition: background-color 0.3s;'>
                                                <i class='fas fa-trash-alt me-1'></i> Borrar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class='accordion-item'>
        <h2 class='accordion-header'>
            <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#vehiculosFavoritos' aria-expanded='false'>
                Mis coches favoritos
            </button>
        </h2>
        <div id='vehiculosFavoritos' class='accordion-collapse collapse'>
            <div class='accordion-body'>
                <p>Coches favoritos</p>
            </div>
        </div>
    </div>
</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php include_once '../../components/footer-example.php'; ?>
    <script src="../../js/borrar_imagen.js"></script>
    <script src="../../js/confirmar_borrar.js"></script>
</body>
</html>