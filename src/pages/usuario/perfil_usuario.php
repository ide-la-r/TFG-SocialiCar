<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

require(__DIR__ . "/../../config/conexion.php");
require(__DIR__ . "/../../config/depurar.php");

// Redirigir si no hay sesión iniciada
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
            // Obtener la extensión
            $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
            $nuevo_nombre = "img_perfil." . $extension;

            // Ruta relativa y absoluta
            $ruta_relativa = "/clients/img/" . $identificacion . "/perfil";
            $ruta_absoluta = $_SERVER['DOCUMENT_ROOT'] . $ruta_relativa;

            // Crear carpeta si no existe
            if (!is_dir($ruta_absoluta)) {
                mkdir($ruta_absoluta, 0777, true);
            }

            $ruta_final = $ruta_absoluta . "/" . $nuevo_nombre;
            $ruta_relativa_final = $ruta_relativa . "/" . $nuevo_nombre;

            // Mover imagen
            if (move_uploaded_file($temporal, $ruta_final)) {
                $ruta_img_guardada = $ruta_relativa_final;

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

                                            <!-- Contenedor de imagen + botón -->
                                            <div class="d-flex flex-column align-items-center mb-3 position-relative" style="padding-top: 50px;">

                                                <!-- Imagen circular -->
                                                <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; border: 4px solid #6BBFBF; background-color: #F2F2F2; position: absolute; top: 0;">
                                                    <?php 
                                                        $img_sql = $_conexion->prepare("SELECT foto_perfil FROM usuario WHERE identificacion = ?");
                                                        $img_sql->bind_param("s", $_SESSION['usuario']['identificacion']);
                                                        $img_sql->execute();
                                                        $resultado = $img_sql->get_result();
                                                        $fila = $resultado->fetch_assoc();

                                                        if (!empty($fila['foto_perfil'])) {
                                                            // Mostrar la imagen desde la base de datos
                                                            echo '<img id="preview_perfil" src="' . htmlspecialchars($fila['foto_perfil']) . '" alt="Foto de perfil" style="width: 100%; height: 100%; object-fit: cover;">';
                                                        } else {
                                                            // Mostrar imagen por defecto
                                                            echo '<img id="preview_perfil" src="/src/img/perfil.png" alt="Foto de perfil" style="width: 100%; height: 100%; object-fit: cover;">';
                                                        }
                                                    ?>
                                                </div>

                                                <!-- Espacio para que no se solape con la imagen -->
                                                <div style="height: 100px;"></div>

                                                <!-- Botón subir foto -->
                                                <label for="img" class="btn btn-outline-success fw-bold" style="border-radius: 2rem; cursor:pointer;">
                                                    Subir foto
                                                </label>

                                                <!-- Input oculto -->
                                                <input 
                                                    class="form-control <?php if (isset($err_imagen_perfil)) echo 'is-invalid'; ?>" 
                                                    id="img" 
                                                    type="file" 
                                                    name="img_perfil" 
                                                    accept="image/png, image/jpg, image/jpeg, image/webp" 
                                                    style="display:none;" 
                                                    onchange="mostrarImagen(this);">
                                            </div>

                                            <!-- Mostrar errores -->
                                            <?php
                                            if (isset($err_imagen_perfil)) {
                                                echo "<span class='error'>$err_imagen_perfil</span>";
                                            }
                                            ?>

                                            <!-- Botones de acción -->
                                            <div id="botones_accion" class="d-none flex-column align-items-center mt-3">
                                                <button type="submit" form="formFotoPerfil" class="btn btn-primary mb-2" style="border-radius: 2rem;">
                                                    Guardar
                                                </button>
                                                <button type="button" class="btn btn-danger" style="border-radius: 2rem;" onclick="borrarImagen();">
                                                    Borrar
                                                </button>
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
                                        // Obtener datos usurio
                                        $sql = $_conexion->prepare("SELECT * FROM usuario WHERE identificacion = ?");
                                        $sql->bind_param("s", $_SESSION['usuario']['identificacion']);
                                        $sql->execute();
                                        $resultado = $sql->get_result();

                                        if ($resultado->num_rows > 0) {
                                            $fila = $resultado->fetch_assoc();
                                            $nombre = $fila["nombre"];
                                            $apellidos = $fila["apellido"];
                                            $correo = $fila["correo"];
                                            $telefono = $fila["telefono"];
                                        }

                                    ?>
                                    <li><strong>Nombre:</strong> <?php echo $nombre . " " . $apellidos; ?></li>
                                    <li><strong>Email:</strong> <?php echo $correo; ?></li>
                                    <li><strong>Teléfono:</strong> <?php echo $telefono; ?></li>
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
                                function formatearFecha($fecha, $meses)
                                {
                                    $dia = $fecha->format('d');
                                    $mes = $meses[$fecha->format('m')];
                                    $anio = $fecha->format('Y');
                                    return "$dia de $mes de $anio";
                                }

                                // Array de meses
                                $meses = [
                                    '01' => 'enero',
                                    '02' => 'febrero',
                                    '03' => 'marzo',
                                    '04' => 'abril',
                                    '05' => 'mayo',
                                    '06' => 'junio',
                                    '07' => 'julio',
                                    '08' => 'agosto',
                                    '09' => 'septiembre',
                                    '10' => 'octubre',
                                    '11' => 'noviembre',
                                    '12' => 'diciembre'
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
                                                    <h5 class='card-title'>" . $vehiculo['marca'] . ' ' . $vehiculo['modelo'] . "</h5>
                                                    
                                                    <div class='row'>
                                                        <div class='col-6'>
                                                            <p class='card-text'>Fecha matriculación: " . ucfirst($fechaMatriculacionFormateada) . "</p>
                                                            <p class='card-text'>Matrícula: " . $vehiculo['matricula'] . "</p>
                                                            <p class='card-text'>Kilometraje: " . $vehiculo['kilometros'] . "</p>
                                                        </div>
                                                        
                                                        <div class='col-6'>
                                                            <p class='card-text'>Fecha de registro: " . $fechaRegistroFormateada . "</p>
                                                            <p class='card-text'>Última actualización: " . $fechaActualizacionFormateada . "</p>
                                                            <p class='card-text'>Tipo: " . ucfirst($vehiculo['tipo']) . "</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class='d-flex justify-content-end'>
                                                        <a href='../coche/editar_coche?matricula=" . $vehiculo['matricula'] . "' class='btn btn-primary me-2'>Editar</a>
                                                        <a href='../coche/eliminar_coche?matricula=" . $vehiculo['matricula'] . "' class='btn btn-danger' onclick='return borrar(\"" . $vehiculo['matricula'] . "\")'>Eliminar</a>
                                                    </div>
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
    <script src="../../js/borrar_imagen.js"></script>
    <script src="../../js/confirmar_borrar.js"></script>
</body>

</html>