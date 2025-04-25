<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    session_start();
    require('../../config/conexion.php');
    require('../../config/depurar.php')
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesion</title>
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
        <?php
        $nombre = $_GET["nombre"];
        $apellido = $_GET["apellido"];
        $correo = $_GET["correo"];
        $foto_perfil = $_GET["foto_perfil"];
        $telefono = $_GET["telefono"];

        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $resultado = $_conexion->query($sql);

        while ($fila = $resultado->fetch_assoc()) {
            $contrasena = $fila["contrasena"];
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST["correo"];
            $apellido = $_POST["apellido"];
            $correo = $_POST["correo"];
            $contrasena = $_POST["contrasena"];
            //$foto_perfil = $_POST["foto_perfil"];
            $telefono = $_POST["telefono"];

            $confirmar = true;

            if ($nueva_contrasena == '') {
                $confirmar = false;
                $err_contrasena = "La contraseña es obligatoria";
            } else {
                $patron = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";
                if (strlen($nueva_contrasena) < 8 || strlen($nueva_contrasena) > 15) {
                    $confirmar = false;
                    $err_contrasena = "La contraseña no puede tener menos de 8 caracteres o mas de 15";
                } elseif (!preg_match($patron, $nueva_contrasena)) {
                    $confirmar = false;
                    $err_contrasena = "La contraseña tiene que tener letras minusculas, mayusculas, algun numero y puede tener caracteres especiales";
                }
            }

            if ($confirmar) {
                $contrasena_cifrada = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
                $sql = "UPDATE usuarios SET contrasena = '$contrasena_cifrada' WHERE usuario = '$usuario'";
                $_conexion->query($sql);
            }
        }
        ?>
        <div class="container card text-center card-sesion" style="width: 40rem;">
            <h1 class="title">Iniciar sesión</h1>
            <form method="post" action="" class="form-floating">
                <div class="row justify-content-center">
                    <div class="row justify-content-center">
                        <div class="mb-3 col-4">
                            <input class="form-control" type="text" placeholder="Nombre*" name="nombre" value="<?php if (isset($nombre)) echo "$nombre" ?>">
                            <?php if (isset($err_nombre)) echo "<span class='error'>$err_nombre</span>" ?>
                        </div>
                        <div class="mb-3 col-4">
                            <input class="form-control" type="text" placeholder="Apellidos*" name="apellido" value="<?php if (isset($apellido)) echo "$apellido" ?>">
                            <?php if (isset($err_apellido)) echo "<span class='error'>$err_apellido</span>" ?>
                        </div>
                    </div>
                    <div class="mb-3 col-8">
                        <input name="correo" class="form-control" type="text" placeholder="Correo electronico*" value="<?php if (isset($correo)) echo "$correo" ?>">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>