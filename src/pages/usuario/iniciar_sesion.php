<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="../../../src/img/favicon.png" />
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    
    require(__DIR__ . "/../../config/conexion.php");
    require(__DIR__ . "/../../config/depurar.php");
    ?>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include_once '../../components/navbar.php'; ?>
    <div class="container mt-5 pt-5">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $correo = $_POST["correo"];
            $contrasena = $_POST["contrasena"];

            $sql = "SELECT * FROM usuario WHERE correo = '$correo'";
            $resultado = $_conexion->query($sql);

            if ($resultado->num_rows == 0) {
                $err_correo = "El correo electronico no existe";
            } else {
                $datos_usuario = $resultado->fetch_assoc();
                $acceso_concedido = password_verify($contrasena, $datos_usuario["contrasena"]);

                if ($acceso_concedido) {
                    session_start();
                    $_SESSION["usuario"] = $datos_usuario["nombre"];
                    header("location: iniciar_sesion.php");
                    exit();
                } else {
                    $err_contrasena = "La contraseña es incorrecta";
                }
            }
        }
        ?>
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
                <input type="submit" class="btn col-4">
            </form>
            <div class="mb-3 iniciar_sesion_pregunta">
                <p>¿Todavía no tienes cuenta? <a href="./registro.php">Registrarse</a></p>
            </div>
        </div>
    </div>
    <?php include_once '../../components/footer.php'; ?>

</body>

</html>