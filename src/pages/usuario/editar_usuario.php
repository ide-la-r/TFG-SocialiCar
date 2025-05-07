<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

require(__DIR__ . "/../../config/conexion.php");
require(__DIR__ . "/../../config/depurar.php");

$correo = $_SESSION["usuario"]["correo"];

$sql = $_conexion->prepare("SELECT * FROM usuario WHERE correo = ?");
$sql->bind_param("s", $correo);
$sql->execute();
$resultado = $sql->get_result();
$_conexion->close();

while ($fila = $resultado->fetch_assoc()) {
    $nombre = $fila["nombre"];
    $apellido = $fila["apellido"];
    $contrasena = $fila["contrasena"];
    $foto_perfil = $fila["foto_perfil"];
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
    //$nueva_foto_perfil = $_POST["foto_perfil"];
    $nuevo_telefono = depurar($_POST["telefono"]);
    $nueva_identificacion = depurar($_POST["identificacion"]);

    $confirmar = true;

    if ($nuevo_nombre == '') {
        $confirmar = false;
        $err_nombre = "El nombre es obligatorio";
    } else {
        $patron = "/^[a-zA-Z áéióúÁÉÍÓÚñÑüÜ'-]+$/";
        if (!preg_match($patron, $nuevo_nombre)) {
            var_dump($nuevo_nombre);
            $confirmar = false;
            $err_nombre = "El nombre solo puede tener letras";
        }
    }

    if ($nuevo_apellido == '') {
        $confirmar = false;
        $err_apellido = "El nombre es obligatorio";
    } else {
        $patron = "/^[a-zA-Z áéióúÁÉÍÓÚñÑüÜ'-]+$/";
        if (!preg_match($patron, $nuevo_apellido)) {
            $confirmar = false;
            $err_apellido = "El apellido solo puede tener letras";
        }
    }

    if ($nuevo_correo == '') {
        $confirmar = false;
        $err_correo = "El correo es obligatorio";
    } elseif (filter_var($nuevo_correo, FILTER_VALIDATE_EMAIL) == false) {
        $confirmar = false;
        $err_correo = "El correo tiene que tener el @ y el . bien colocados";
    }

    if (!password_verify($contrasena_original, $contrasena)) {
        $confirmar = false;
        $err_contrasena_original = "Porfavor, inserte la contraseña actual parta cambiar los datos";
    }

    if ($nueva_contrasena == '') {
        $confirmar = false;
        $err_nueva_contrasena = "La contraseña es obligatoria";
    } else {
        if (strlen($nueva_contrasena) < 7 || strlen($nueva_contrasena) > 20) {
            $confirmar = false;
            $err_nueva_contrasena = "La contraseña tiene que tener como minimo 7 y como maximo 20 caracteres";
        } else {
            $patron = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/";
            if (!preg_match($patron, $nueva_contrasena)) {
                $confirmar = false;
                $err_nueva_contrasena = "La contraseña tiene que tener al menos 1 mayuscula, 1 minuscula y 1 numero";
            } else {
                $contrasena_cifrada = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
            }
        }
    }

    if ($confirma_contrasena !== $nueva_contrasena) {
        $confirmar = false;
        $err_confirma_contrasena = "Las contraseñas no coinciden";
    }

    if ($nuevo_telefono == '') {
        $confirmar = false;
        $err_telefono = "El telefono es obligatorio";
    } else {
        $patron = "/^\d{9,15}$/";
        if (!preg_match($patron, $nuevo_telefono)) {
            $confirmar = false;
            $err_telefono = "El teléfono debe contener solo dígitos y tener entre 9 y 15 números";
        }
    }

    if ($nueva_identificacion == '') {
        $confirmar = false;
        $err_identificacion = "La identificación es obligatoria";
    } else {
        $tipo_identificacion = $_SESSION['usuario']['tipo_identificacion'];
        if ($tipo_identificacion == "dni") {
            //patron DNI
            $patron = "/^[0-9]{8}[A-Za-z]$/";
            if (!preg_match($patron, $nueva_identificacion)) {
                $confirmar = false;
                $err_identificacion = "La DNI debe tener 8 digitos y una letra al final";
            }
        } elseif ($tipo_identificacion == "nie") {
            //patron NIE
            $patron = "/^[XYZ][0-9]{7}[A-Za-z]$/";
            if (!preg_match($patron, $nueva_identificacion)) {
                $confirmar = false;
                $err_identificacion = "El NIE debe tener una X,Y o Z, siguiendo de 7 digitos y una letra al final";
            }
        } elseif ($tipo_identificacion == "nif") {
            //patron NIF
            $patron = "/^[0-9]{8}[A-Za-z]$/";
            if (!preg_match($patron, $nueva_identificacion)) {
                $confirmar = false;
                $err_identificacion = "El NIF debe tener 8 digitos y una letra al final";
            }
        }
    }

    if ($confirmar) {
        $sql = $_conexion->prepare("UPDATE usuario SET nombre = ?, 
                                    apellido = ?, 
                                    correo = ?, 
                                    contrasena = ?, 
                                    telefono = ?, 
                                    identificacion = ? WHERE correo = ?");

        $sql->bind_param("sssssss", $nuevo_nombre, $nuevo_apellido, $nuevo_correo, $contrasena_cifrada, $nuevo_telefono, $nueva_identificacion, $correo);
        
        $sql->execute();

        header("location: ./perfil_usuario");
        exit();
    }
}
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
        <div class="container card text-center card-sesion" style="width: 40rem;">
            <h1 class="title">Editar perfil</h1>
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
                        <input name="correo" class="form-control" type="email" placeholder="Correo electronico*" value="<?php if (isset($correo)) echo "$correo" ?>">
                        <?php if (isset($err_correo)) echo "<span class='error'>$err_correo</span>" ?>
                    </div>
                    <!-- Confirmar contraseña -->
                    <div class="mb-3 col-8">
                        <input name="contrasena_original" class="form-control" type="password" placeholder="Contraseña actual*">
                        <?php if (isset($err_contrasena_original)) echo "<span class='error'>$err_contrasena_original</span>" ?>
                    </div>
                    <div class="mb-3 col-8">
                        <input name="contrasena" class="form-control" type="password" placeholder="Nueva contraseña*">
                        <?php if (isset($err_nueva_contrasena)) echo "<span class='error'>$err_nueva_contrasena</span>" ?>
                    </div>
                    <div class="mb-3 col-8">
                        <input name="confirma_contrasena" class="form-control" type="password" placeholder="Confirmar nueva contraseña*">
                        <?php if (isset($err_confirma_contrasena)) echo "<span class='error'>$err_confirma_contrasena</span>" ?>
                    </div>
                    <!-- FOTO DE PERFIL -->
                    <div class="mb-3 col-8">
                        <input name="telefono" class="form-control" type="text" placeholder="Correo electronico*" value="<?php if (isset($telefono)) echo "$telefono" ?>">
                        <?php if (isset($err_telefono)) echo "<span class='error'>$err_telefono</span>" ?>
                    </div>
                    <div class="mb-3 col-8">
                        <input name="identificacion" class="form-control" type="text" placeholder="Correo electronico*" value="<?php if (isset($identificacion)) echo "$identificacion" ?>">
                        <?php if (isset($err_identificacion)) echo "<span class='error'>$err_identificacion</span>" ?>
                    </div>
                </div>
                <input type="submit" class="btn col-4" value="Editar">
            </form>
        </div>
    </div>
    <?php include_once '../../components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>