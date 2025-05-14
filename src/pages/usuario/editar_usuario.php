<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar perfil</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    session_start();

    if (!isset($_SESSION['usuario'])) {
        header("Location: ../../../");
        exit();
    }

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
    <?php
    $correo = $_SESSION["usuario"]["correo"];

    $sql = $_conexion->prepare("SELECT * FROM usuario WHERE correo = ?");
    $sql->bind_param("s", $correo);
    $sql->execute();
    $resultado = $sql->get_result();

    while ($fila = $resultado->fetch_assoc()) {
        $nombre = $fila["nombre"];
        $apellido = $fila["apellido"];
        $contrasena = $fila["contrasena"];
        //$foto_perfil = $fila["foto_perfil"];
        $telefono = $fila["telefono"];
        $identificacion = $fila["identificacion"];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nuevo_nombre = depurar($_POST["nombre"]);
        $nuevo_apellido = depurar($_POST["apellido"]);
        $nuevo_correo = depurar($_POST["correo"]);
        $contrasena_original = depurar($_POST["contrasena_original"]);
        $nueva_contrasena = depurar($_POST["contrasena"]);
        $confirma_contrasena = depurar($_POST["confirma_contrasena"]);
        $nuevo_telefono = depurar($_POST["telefono"]);
        $nueva_identificacion = depurar($_POST["identificacion"]);

        $confirmar = true;

        if ($nuevo_nombre == '') {
            $confirmar = false;
            $err_nombre = "El nombre es obligatorio";
        } elseif (!preg_match("/^[a-zA-Z áéióúÁÉÍÓÚñÑüÜ'-]+$/", $nuevo_nombre)) {
            $confirmar = false;
            $err_nombre = "El nombre solo puede tener letras";
        }

        if ($nuevo_apellido == '') {
            $confirmar = false;
            $err_apellido = "El apellido es obligatorio";
        } elseif (!preg_match("/^[a-zA-Z áéióúÁÉÍÓÚñÑüÜ'-]+$/", $nuevo_apellido)) {
            $confirmar = false;
            $err_apellido = "El apellido solo puede tener letras";
        }

        if ($nuevo_correo == '') {
            $confirmar = false;
            $err_correo = "El correo es obligatorio";
        } elseif (!filter_var($nuevo_correo, FILTER_VALIDATE_EMAIL)) {
            $confirmar = false;
            $err_correo = "El correo tiene que tener el @ y el . bien colocados";
        }

        if (!password_verify($contrasena_original, $contrasena)) {
            $confirmar = false;
            $err_contrasena_original = "Por favor, inserte la contraseña actual para cambiar los datos";
        }

        if ($nueva_contrasena == '') {
            $confirmar = false;
            $err_nueva_contrasena = "La contraseña es obligatoria";
        } elseif (strlen($nueva_contrasena) < 7 || strlen($nueva_contrasena) > 20) {
            $confirmar = false;
            $err_nueva_contrasena = "La contraseña debe tener entre 7 y 20 caracteres";
        } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/", $nueva_contrasena)) {
            $confirmar = false;
            $err_nueva_contrasena = "Debe tener al menos 1 mayúscula, 1 minúscula y 1 número";
        } else {
            $contrasena_cifrada = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        }

        if ($confirma_contrasena !== $nueva_contrasena) {
            $confirmar = false;
            $err_confirma_contrasena = "Las contraseñas no coinciden";
        }

        if ($nuevo_telefono == '') {
            $confirmar = false;
            $err_telefono = "El teléfono es obligatorio";
        } elseif (!preg_match("/^\d{9,15}$/", $nuevo_telefono)) {
            $confirmar = false;
            $err_telefono = "Debe contener solo dígitos y tener entre 9 y 15 caracteres";
        }

        if ($nueva_identificacion == '') {
            $confirmar = false;
            $err_identificacion = "La identificación es obligatoria";
        } else {
            $tipo_identificacion = $_SESSION['usuario']['tipo_identificacion'];
            if ($tipo_identificacion == "dni" || $tipo_identificacion == "nif") {
                if (!preg_match("/^[0-9]{8}[A-Za-z]$/", $nueva_identificacion)) {
                    $confirmar = false;
                    $err_identificacion = "Debe tener 8 dígitos y una letra al final";
                }
            } elseif ($tipo_identificacion == "nie") {
                if (!preg_match("/^[XYZ][0-9]{7}[A-Za-z]$/", $nueva_identificacion)) {
                    $confirmar = false;
                    $err_identificacion = "Debe comenzar con X, Y o Z, seguido de 7 dígitos y una letra";
                }
            }
        }

        if ($confirmar) {
            $sql = $_conexion->prepare("UPDATE usuario SET nombre = ?, apellido = ?, correo = ?, contrasena = ?, telefono = ?, identificacion = ? WHERE correo = ?");
            $sql->bind_param("sssssss", $nuevo_nombre, $nuevo_apellido, $nuevo_correo, $contrasena_cifrada, $nuevo_telefono, $nueva_identificacion, $correo);
            $sql->execute();

            header("location: /src/pages/usuario/perfil_usuario");
            exit();
        }
        
    }
    ?>
    <?php include_once '../../components/navbar.php'; ?>
    <div class="container mt-5 pt-5">
        <div class="container card text-center card-sesion" style="width: 40rem;">
            <h1 class="title">Editar perfil</h1>
            <form method="post" class="form-floating">
                <div class="row justify-content-center">
                    <div class="mb-3 col-4">
                        <input class="form-control" type="text" name="nombre" placeholder="Nombre*" value="<?= htmlspecialchars($nombre ?? '') ?>">
                        <?php if (isset($err_nombre)) echo "<span class='error'>$err_nombre</span>"; ?>
                    </div>
                    <div class="mb-3 col-4">
                        <input class="form-control" type="text" name="apellido" placeholder="Apellidos*" value="<?= htmlspecialchars($apellido ?? '') ?>">
                        <?php if (isset($err_apellido)) echo "<span class='error'>$err_apellido</span>"; ?>
                    </div>
                    <div class="mb-3 col-8">
                        <input class="form-control" type="email" name="correo" placeholder="Correo electrónico*" value="<?= htmlspecialchars($correo ?? '') ?>">
                        <?php if (isset($err_correo)) echo "<span class='error'>$err_correo</span>"; ?>
                    </div>
                    <div class="mb-3 col-8">
                        <input class="form-control" type="password" name="contrasena_original" placeholder="Contraseña actual*">
                        <?php if (isset($err_contrasena_original)) echo "<span class='error'>$err_contrasena_original</span>"; ?>
                    </div>
                    <div class="mb-3 col-8">
                        <input class="form-control" type="password" name="contrasena" placeholder="Nueva contraseña*">
                        <?php if (isset($err_nueva_contrasena)) echo "<span class='error'>$err_nueva_contrasena</span>"; ?>
                    </div>
                    <div class="mb-3 col-8">
                        <input class="form-control" type="password" name="confirma_contrasena" placeholder="Confirmar nueva contraseña*">
                        <?php if (isset($err_confirma_contrasena)) echo "<span class='error'>$err_confirma_contrasena</span>"; ?>
                    </div>
                    <div class="mb-3 col-8">
                        <input class="form-control" type="text" name="telefono" placeholder="Teléfono*" value="<?= htmlspecialchars($telefono ?? '') ?>">
                        <?php if (isset($err_telefono)) echo "<span class='error'>$err_telefono</span>"; ?>
                    </div>
                    <div class="mb-3 col-8">
                        <input class="form-control" type="text" name="identificacion" placeholder="Identificación*" value="<?= htmlspecialchars($identificacion ?? '') ?>">
                        <?php if (isset($err_identificacion)) echo "<span class='error'>$err_identificacion</span>"; ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Guardar cambios</button>
            </form>
        </div>
    </div>
    <?php include_once '../../components/footer.php'; ?>
</body>

</html>
