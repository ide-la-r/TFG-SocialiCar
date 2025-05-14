<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

require(__DIR__ . "/../../config/conexion.php");
require(__DIR__ . "/../../config/depurar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    $sql = $_conexion->prepare("SELECT * FROM usuario WHERE correo = ?");
    $sql->bind_param("s", $correo);
    $sql->execute();
    $resultado = $sql->get_result();

    if ($resultado->num_rows == 0) {
        $err_correo = "El correo electrónico no existe";
    } else {
        $datos_usuario = $resultado->fetch_assoc();
        $acceso_concedido = password_verify($contrasena, $datos_usuario["contrasena"]);

        if ($acceso_concedido) {
            $_SESSION["usuario"] = $datos_usuario;

            $sql = $_conexion->prepare("UPDATE usuario SET estado = 1 WHERE identificacion = ?");
            $sql->bind_param("s", $datos_usuario["identificacion"]);
            $sql->execute();
            $sql->close();

            $_conexion->close();

            header("location: ../../../index.php");
            exit();
        } else {
            $err_contrasena = "La contraseña es incorrecta";
            $_conexion->close();
        }
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
    <link rel="stylesheet" href="../../styles/nuevo_coche_custom.css">
    <style>
        .error {
            color: red;
            font-size: 0.875rem;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include_once '../../components/navbar.php'; ?>
    <div class="container mt-5 pt-5 d-flex justify-content-center align-items-center">
        <div class="card text-center card-sesion w-100 w-md-50 p-4 rounded-4 shadow mx-auto" style="max-width: 420px;">
            <h1 class="title pt-2 pb-3">Iniciar sesión</h1>
            <form method="post" action="">
                <div class="row justify-content-center">
                    <div class="mb-3 col-12 col-md-8 mx-auto form-floating">
                        <input name="correo" id="correo" class="form-control <?php if (isset($err_correo)) echo 'is-invalid'; ?>" type="email" placeholder="Correo electrónico" value="<?= isset($correo) ? htmlspecialchars($correo) : '' ?>">
                        <label for="correo">Correo electrónico</label>
                        <?php if (isset($err_correo)) echo "<div class='error mt-1'>$err_correo</div>"; ?>
                    </div>

                    <div class="mb-3 col-12 col-md-8 mx-auto form-floating">
                        <input name="contrasena" id="contrasena" class="form-control <?php if (isset($err_contrasena)) echo 'is-invalid'; ?>" type="password" placeholder="Contraseña">
                        <label for="contrasena">Contraseña</label>
                        <?php if (isset($err_contrasena)) echo "<div class='error mt-1'>$err_contrasena</div>"; ?>
                    </div>
                </div>

                <input type="submit" class="btn btn-primary w-100 mt-2" value="Iniciar sesión">
            </form>
            <div class="mb-3 iniciar_sesion_pregunta">
                <p>¿Todavía no tienes cuenta? <a href="./registro">Registrarse</a></p>
            </div>
        </div>
    </div>
    <?php include_once '../../components/footer-example.php'; ?>
</body>

</html>
