<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .error {
            color: red;
        }
    </style>
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    require('../../config/conexion.php');
    require('../../config/depurar.php');
    ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include_once '../../components/navbar.php'; ?>
    <div class="container mt-5 pt-5">
        <?php
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

            $sql = "SELECT * FROM usuario WHERE correo = '$correo'";
            $resultado = $_conexion->query($sql);

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
        ?>
        <div class="container card text-center card_registro" style="width: 40rem;">
            <h1 class="register">Registrarse</h1>
            <form action="" method="post" class="form-floating">
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

                <div class="row justify-content-center">
                    <div class="mb-3 col-8">
                        <input class="form-control" type="email" placeholder="Correo electronico*" name="correo" value="<?php if (isset($correo)) echo "$correo" ?>">
                        <?php if (isset($err_correo)) echo "<span class='error'>$err_correo</span>" ?>
                    </div>

                    <div class="mb-3 col-8">
                        <input id="contrasena" class="form-control" type="password" placeholder="Contraseña*" name="contrasena">
                        <?php if (isset($err_contrasena)) echo "<span class='error'>$err_contrasena</span>" ?>
                    </div>

                    <div class="mb-3 col-8">
                        <input id="validarContrasena" class="form-control" type="password" hidden placeholder="Confirmar contraseña*" name="confirma_contrasena">
                        <?php if (isset($err_confirma_contrasena)) echo "<span class='error'>$err_confirma_contrasena</span>" ?>
                    </div>

                    <div class="mb-3 col-8">
                        <input class="form-control" type="text" placeholder="Teléfono*" name="telefono" value="<?php if (isset($telefono)) echo "$telefono" ?>">
                        <?php if (isset($err_telefono)) echo "<span class='error'>$err_telefono</span>" ?>
                    </div>

                    <div class="mb-3 col-8">
                        <select id="tipoIdentificacion" class="form-select" name="tipo_identificacion">
                            <option disabled hidden value="" <?php if (!isset($tipo_identificacion) || $tipo_identificacion == '') echo 'selected'; ?>>Tipo de identificación*</option>
                            <option value="dni" <?php if (isset($tipo_identificacion) && $tipo_identificacion == 'dni') echo 'selected'; ?>>DNI</option>
                            <option value="nie" <?php if (isset($tipo_identificacion) && $tipo_identificacion == 'nie') echo 'selected'; ?>>NIE</option>
                            <option value="nif" <?php if (isset($tipo_identificacion) && $tipo_identificacion == 'nif') echo 'selected'; ?>>NIF</option>
                        </select>
                        <?php if (isset($err_tipo_identificacion)) echo "<span class='error'>$err_tipo_identificacion</span>"; ?>
                    </div>

                    <div class="mb-3 col-8">
                        <input class="form-control" placeholder="Identificación*" id="identificacion" name="identificacion" type="text" hidden>
                        <?php if (isset($err_identificacion) && $tipo_identificacion != "") echo "<span class='error'>$err_identificacion</span>" ?>
                    </div>
                </div>

                <input type="submit" class="btn col-4" value="Registrarse">
            </form>
            <div class="mb-3 iniciar_sesion_pregunta">
                <p>¿Ya tienes cuenta? <a href="./iniciar_sesion.php">Iniciar sesión</a></p>
            </div>
        </div>
    </div>
    <?php include_once '../../components/footer.php'; ?>
    <script src="../../js/registro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>