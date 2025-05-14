<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require(__DIR__ . "/../../config/conexion.php");
require(__DIR__ . "/../../config/depurar.php");

session_start();
if (isset($_SESSION["usuario"])) {
    header("location: ../../../index.php");
    exit();
}

$mostrar_identificacion = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = depurar($_POST["nombre"]);
    $apellido = depurar($_POST["apellido"]);
    $correo = depurar($_POST["correo"]);
    $contrasena = depurar($_POST["contrasena"]);
    $confirma_contrasena = depurar($_POST["confirma_contrasena"]);
    $telefono = depurar($_POST["telefono"]);
    $tipo_identificacion = isset($_POST["tipo_identificacion"]) ? depurar($_POST["tipo_identificacion"]) : '';
    $identificacion = depurar($_POST["identificacion"]);
    $fecha_nacimiento = depurar($_POST["fecha_nacimiento"]);
    $foto_perfil = "";
    $ruta_img_identificacion = "";
    $ruta_img_carnet = "";

    $confirmar = true;

    if ($nombre == '') {
        $confirmar = false;
        $err_nombre = "El nombre es obligatorio";
    } else {
        $patron = "/^[a-zA-Z0-9 áéióúÁÉÍÓÚñÑüÜ'-]+$/";
        if (!preg_match($patron, $nombre)) {
            $confirmar = false;
            $err_nombre = "El nombre solo puede tener letras";
        }
    }

    if ($apellido == '') {
        $confirmar = false;
        $err_apellido = "El nombre es obligatorio";
    } else {
        $patron = "/^[a-zA-Z áéióúÁÉÍÓÚñÑüÜ'-]+$/";
        if (!preg_match($patron, $apellido)) {
            $confirmar = false;
            $err_apellido = "El apellido solo puede tener letras";
        }
    }

    $sql = $_conexion->prepare("SELECT * FROM usuario WHERE correo = ?");
    $sql->bind_param("s", $correo);
    $sql->execute();
    $resultado = $sql->get_result();

    if ($correo == '') {
        $confirmar = false;
        $err_correo = "El correo es obligatorio";
    } else {
        if ($resultado->num_rows == 1) {
            $confirmar = false;
            $err_correo = "El correo ya existe";
        } else {
            if (filter_var($correo, FILTER_VALIDATE_EMAIL) == false) {
                $confirmar = false;
                $err_correo = "El correo tiene que tener el @ y el . bien colocados";
            }
        }
    }

    if ($contrasena == '') {
        $confirmar = false;
        $err_contrasena = "La contraseña es obligatoria";
    } else {
        if (strlen($contrasena) < 7 || strlen($contrasena) > 20) {
            $confirmar = false;
            $err_contrasena = "La contraseña tiene que tener como minimo 7 y como maximo 20 caracteres";
        } else {
            $patron = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/";
            if (!preg_match($patron, $contrasena)) {
                $confirmar = false;
                $err_contrasena = "La contraseña tiene que tener al menos 1 mayuscula, 1 minuscula y 1 numero";
            } else {
                $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);
            }
        }
    }

    if ($confirma_contrasena !== $contrasena) {
        $confirmar = false;
        $err_confirma_contrasena = "Las contraseñas no coinciden";
    }

    if ($telefono == '') {
        $confirmar = false;
        $err_telefono = "El telefono es obligatorio";
    } else {
        $patron = "/^\d{9,15}$/";
        if (!preg_match($patron, $telefono)) {
            $confirmar = false;
            $err_telefono = "El teléfono debe contener solo dígitos y tener entre 9 y 15 números";
        }
    }

    $identificaciones = ["dni", "nie", "nif"];
    if ($tipo_identificacion == '') {
        $confirmar = false;
        $err_tipo_identificacion = "Es obligatorio seleccionar un tipo de identificación";
    } elseif (!in_array($tipo_identificacion, $identificaciones)) {
        $confirmar = false;
        $err_tipo_identificacion = "Tienes que elegir un tipo de identificación existente";
    } else {
        $mostrar_identificacion = true;
    }

    if ($identificacion == '') {
        $confirmar = false;
        $err_identificacion = "La identificación es obligatoria";
    } else {

        $sql = $_conexion->prepare("SELECT * FROM usuario WHERE identificacion = ?");
        $sql->bind_param("s", $identificacion);
        $sql->execute();
        $resultado = $sql->get_result();

        if ($resultado->num_rows == 1) {
            $confirmar = false;
            $err_identificacion = "Esta identificación ya esta registrada";
        } else {
            if ($tipo_identificacion == "dni") {
                //patron DNI
                $patron = "/^[0-9]{8}[A-Za-z]$/";
                if (!preg_match($patron, $identificacion)) {
                    $confirmar = false;
                    $err_identificacion = "La DNI debe tener 8 digitos y una letra al final";
                }
            } elseif ($tipo_identificacion == "nie") {
                //patron NIE
                $patron = "/^[XYZ][0-9]{7}[A-Za-z]$/";
                if (!preg_match($patron, $identificacion)) {
                    $confirmar = false;
                    $err_identificacion = "El NIE debe tener una X,Y o Z, siguiendo de 7 digitos y una letra al final";
                }
            } elseif ($tipo_identificacion == "nif") {
                //patron NIF
                $patron = "/^[0-9]{8}[A-Za-z]$/";
                if (!preg_match($patron, $identificacion)) {
                    $confirmar = false;
                    $err_identificacion = "El NIF debe tener 8 digitos y una letra al final";
                }
            }
        }
    }

    /* Validar fecha de nacimiento */
    if ($fecha_nacimiento == '') {
        $confirmar = false;
        $err_fecha_nacimiento = "La fecha de nacimiento es obligatoria";
    } else {
        $fecha_actual = date("Y-m-d");
        if ($fecha_nacimiento > $fecha_actual) {
            $confirmar = false;
            $err_fecha_nacimiento = "La fecha de nacimiento no puede ser mayor a la fecha actual";
        } else {
            if (date("Y") - date("Y", strtotime($fecha_nacimiento)) < 18) {
                $confirmar = false;
                $err_fecha_nacimiento = "Tienes que ser mayor de edad para registrarte";
            }
        }
    }

    if ($confirmar) {
        $sql = $_conexion->prepare("INSERT INTO usuario (
                identificacion, tipo_identificacion, nombre, apellido, correo, 
                contrasena, telefono, foto_perfil, ruta_img_identificacion, 
                ruta_img_carnet, verificado, fecha_nacimiento, estado
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?, 1)");

        $sql->bind_param(
            "sssssssssss",
            $identificacion,
            $tipo_identificacion,
            $nombre,
            $apellido,
            $correo,
            $contrasena_cifrada,
            $telefono,
            $foto_perfil,
            $ruta_img_identificacion,
            $ruta_img_carnet,
            $fecha_nacimiento
        );

        if ($sql->execute()) {
            $sql = $_conexion->prepare("SELECT * FROM usuario WHERE correo = ?");
            $sql->bind_param("s", $correo);
            $sql->execute();
            $resultado = $sql->get_result();

            $_conexion->close();

            if ($resultado->num_rows === 1) {
                $datos_usuario = $resultado->fetch_assoc();
                $_SESSION["usuario"] = $datos_usuario;
                header("Location: ../../../");
                exit();
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
    <title>SocialiCar - Comparte tu coche</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="../../styles/nuevo_coche_custom.css">
    <?php

    ?>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include_once '../../components/navbar.php'; ?>
    <div class="container mt-5 pt-5 d-flex justify-content-center align-items-center">
        <div class="card text-center card_registro w-100 p-4 rounded-4 shadow mx-auto" style="max-width: 420px;">
            <h1 class="register pt-2 pb-3">Registrarse</h1>
            <form action="" method="post">
                <div class="row gy-3">

                    <div class="mb-2 col-12">
                        <div class="form-floating">
                            <input class="form-control <?php if (isset($err_nombre)) echo 'is-invalid'; ?>" type="text" placeholder="Nombre*" id="nombre" name="nombre" value="<?php if (isset($nombre)) echo $nombre; ?>">
                            <label for="nombre">Nombre</label>
                            <?php if (isset($err_nombre)) echo "<span class='error'>$err_nombre</span>"; ?>
                        </div>
                    </div>


                    <div class="mb-2 col-12">
                        <div class="form-floating">
                            <input class="form-control <?php if (isset($err_apellido)) echo 'is-invalid'; ?>" type="text" placeholder="Apellidos*" id="apellido" name="apellido" value="<?php if (isset($apellido)) echo $apellido; ?>">
                            <label for="apellido">Apellido</label>
                            <?php if (isset($err_apellido)) echo "<span class='error'>$err_apellido</span>"; ?>
                        </div>

                    </div>
                </div>

                <div class="row gy-2">
                    <div class="mb-2 col-12">
                        <input class="form-control <?php if (isset($err_fecha_nacimiento)) echo 'is-invalid'; ?>" placeholder="Fecha de nacimiento*" id="fecha_nacimiento" name="fecha_nacimiento" type="date" value="<?php if (isset($fecha_nacimiento)) echo $fecha_nacimiento; ?>">
                        <?php if (isset($err_fecha_nacimiento)) echo "<span class='error'>$err_fecha_nacimiento</span>"; ?>
                    </div>
                    <div class="mb-2 col-12">
                        <div class="form-floating">
                            <input class="form-control <?php if (isset($err_correo)) echo 'is-invalid'; ?>" type="email" id="" placeholder="Correo electrónico*" name="correo" value="<?php if (isset($correo)) echo $correo; ?>">
                            <label for="correo">Correo</label>
                            <?php if (isset($err_correo)) echo "<span class='error'>$err_correo</span>"; ?>
                        </div>

                    </div>
                    <div class="mb-2 col-12">
                        <div class="form-floating">
                            <input id="contrasena" class="form-control <?php if (isset($err_contrasena)) echo 'is-invalid'; ?>" type="password" placeholder="Contraseña*" name="contrasena" value="<?php if (isset($contrasena)) echo $contrasena; ?>">
                            <label for="contrasena">Contraseña</label>
                            <?php if (isset($err_contrasena)) echo "<span class='error'>$err_contrasena</span>"; ?>
                        </div>

                    </div>
                    <div class="mb-2 col-12">
                        <input id="validarContrasena" class="form-control <?php if (isset($err_confirma_contrasena)) echo 'is-invalid'; ?>" type="password" hidden placeholder="Confirmar contraseña*" name="confirma_contrasena">
                        <?php if (isset($err_confirma_contrasena)) echo "<span class='error'>$err_confirma_contrasena</span>"; ?>
                    </div>
                    <div class="mb-2 col-12">
                        <div class="form-floating">
                            <input id="telefono" class="form-control <?php if (isset($err_telefono)) echo 'is-invalid'; ?>" type="text" placeholder="Teléfono*" name="telefono" value="<?php if (isset($telefono)) echo $telefono; ?>">
                            <label for="telefono">Teléfono</label>
                            <?php if (isset($err_telefono)) echo "<span class='error'>$err_telefono</span>"; ?>
                        </div>

                    </div>
                    <div class="mb-2 col-12">
                        <div class="form-floating">
                            <select id="tipoIdentificacion" class="form-select <?php if (isset($err_tipo_identificacion)) echo 'is-invalid'; ?>" name="tipo_identificacion">
                                <option disabled hidden value="" <?php if (!isset($tipo_identificacion) || $tipo_identificacion == '') echo 'selected'; ?>>Tipo de identificación*</option>
                                <option value="dni" <?php if (isset($tipo_identificacion) && $tipo_identificacion == 'dni') echo 'selected'; ?>>DNI</option>
                                <option value="nie" <?php if (isset($tipo_identificacion) && $tipo_identificacion == 'nie') echo 'selected'; ?>>NIE</option>
                                <option value="nif" <?php if (isset($tipo_identificacion) && $tipo_identificacion == 'nif') echo 'selected'; ?>>NIF</option>
                            </select>
                            <label for="tipoIdentificacion">Tipo de identificación</label>
                            <?php if (isset($err_tipo_identificacion)) echo "<span class='error'>$err_tipo_identificacion</span>"; ?>
                        </div>
                    </div>
                    <div class="mb-2 col-12">
                        <input class="form-control" placeholder="Identificación*" id="identificacion" name="identificacion" type="text" hidden>
                        <?php if (isset($err_identificacion) && $tipo_identificacion != "") echo "<span class='error'>$err_identificacion</span>" ?>
                    </div>
                    <div class="col-12 mt-3">
                        <input type="submit" class="btn btn-primary w-100" value="Registrarse">
                    </div>
                </div>
            </form>
            <div class="iniciar_sesion_pregunta mt-3 mb-2 text-center">
                <p>¿Ya tienes cuenta? <a href="./iniciar_sesion" class="registrarse">Iniciar sesión</a></p>
            </div>
        </div>
    </div>
    <br>
    <br>
    
    <?php include_once '../../components/footer-example.php'; ?>
    <script src="../../js/registro.js"></script>
</body>

</html>