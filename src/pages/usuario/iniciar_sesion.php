<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

require(__DIR__ . "/../../config/conexion.php");
require(__DIR__ . "/../../config/depurar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    $sql = $_conexion -> prepare("SELECT * FROM usuario WHERE correo = ?");
    $sql -> bind_param("s", $correo);
    $sql -> execute();
    $resultado = $sql -> get_result();
    $_conexion -> close();

    if ($resultado->num_rows == 0) {
        $err_correo = "El correo electronico no existe";
    } else {
        $datos_usuario = $resultado->fetch_assoc();
        $acceso_concedido = password_verify($contrasena, $datos_usuario["contrasena"]);

        if ($acceso_concedido) {
            $_SESSION["usuario"] = $datos_usuario;
            header("location: ../../../index.php");
            exit();
        } else {
            $err_contrasena = "La contraseña es incorrecta";
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
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include_once '../../components/navbar.php'; ?>
    <div class="container mt-5 pt-5">
        
        <div class="container card text-center card-sesion" style="width: 40rem;">
            <h1 class="title">Iniciar sesión</h1>
            <form method="post" action="" class="form-floating">
                <div class="row justify-content-center">
                    <div class="mb-3 col-8">
                        <input name="correo" class="form-control" type="text" placeholder="Correo electronico*">
                        <?php if (isset($err_correo)) echo "<span class='error'>$err_correo</span>" ?>
                    </div>
                    <div class="mb-3 col-8">
                        <input name="contrasena" class="form-control" type="password" placeholder="Contraseña*">
                        <?php if (isset($err_contrasena)) echo "<span class='error'>$err_contrasena</span>" ?>
                    </div>
                </div>
                <input type="submit" class="btn col-4" value="Iniciar sesión">
            </form>
            <div class="mb-3 iniciar_sesion_pregunta">
                <p>¿Todavía no tienes cuenta? <a href="./registro">Registrarse</a></p>
            </div>
        </div>
    </div>
    <?php include_once '../../components/footer.php'; ?>

</body>

</html>