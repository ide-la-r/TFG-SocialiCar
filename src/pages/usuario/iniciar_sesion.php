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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    
    <link rel="stylesheet" href="../../styles/inicio_sesion.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include_once '../../components/navbar.php'; ?>
    <div class="contenedor-centrado">
        <div class="card">
            <h1 class="titulo-sesion">Iniciar sesión</h1>
            <form method="post" action="" class="formulario-sesion">
                <div class="gy-3">
                    <div class="form-floating">
                        <input class="form-control <?php if (isset($err_correo)) echo 'is-invalid'; ?>" type="email" placeholder="Correo electrónico*" id="correo" name="correo" value="<?php if (isset($correo)) echo htmlspecialchars($correo); ?>">
                        <label for="correo">Correo electrónico</label>
                        <?php if (isset($err_correo)) echo "<span class='error'>$err_correo</span>"; ?>
                    </div>
                    <div class="form-floating">
                        <input class="form-control <?php if (isset($err_contrasena)) echo 'is-invalid'; ?>" type="password" placeholder="Contraseña*" id="contrasena" name="contrasena">
                        <label for="contrasena">Contraseña</label>
                        <?php if (isset($err_contrasena)) echo "<span class='error'>$err_contrasena</span>"; ?>
                    </div>
                </div>

                <input type="submit" class="btn btn-primary boton-sesion" value="Iniciar sesión">
            </form>
            <div class="pregunta-registro">
                <p>¿Todavía no tienes cuenta? </p>
                <a href="./registro">Registrarse</a>
            </div>
        </div>
    </div>

    <?php include_once '../../components/footer-example.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>