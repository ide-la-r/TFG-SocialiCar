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
    ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include_once '../../components/navbar.php'; ?>
    <div class="container mt-5 pt-5">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = $_POST["usuario"];
            $contrasena = $_POST["contrasena"];

            $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
            $resultado = $_conexion->query($sql);

            if ($resultado->num_rows == 0) {
                $err_usuario = "El usuario no existe";
            } else {
                $datos_usuario = $resultado->fetch_assoc();
                /** podemos acceder a:
                 * $datos_usuario["usuario]
                 * $datos_usuario["contraseña]*/
                $acceso_concedido = password_verify($contrasena, $datos_usuario["contrasena"]);

                if ($acceso_concedido) {
                    session_start();
                    $_SESSION["usuario"] = $usuario;
                    header("location: ../../../index.php");
                    exit;
                } else {
                    $err_contrasena = "La contraseña es incorrecta";
                }
            }
        }
        ?>
        <div class="container card text-center card_registro" style="width: 40rem;">
        <h1 class="register">Registrarse</h1>
        <form action="" class="form-floating">
            <div class="row justify-content-center">
                <div class="mb-3 col-4">
                    <input class="form-control" type="text" placeholder="Nombre*" name="nombre">
                </div>
                <div class="mb-3 col-4">
                    <input class="form-control" type="text" placeholder="Apellidos*" name="apellido">
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="mb-3 col-8">
                    <input class="form-control" type="text" placeholder="Email*" name="correo">
                </div>
                
                <div class="mb-3 col-8">
                    <input id="contrasena" class="form-control" type="password" placeholder="Contraseña*" name="contrasena">
                </div>
                
                <div class="mb-3 col-8">
                    <input id="validarContrasena" class="form-control" type="password" hidden placeholder="Confirmar contraseña*" name="confirma_contrasena">
                </div>
                
                <div class="mb-3 col-8">
                    <input class="form-control" type="text" placeholder="Teléfono*" name="telefono">
                </div>
                
                <div class="mb-3 col-8">
                    <Select id="tipoIdentificacion" class="form-select">
                        <option disabled selected hidden>Tipo de identificación*</option>
                        <option value="dni">DNI</option>
                        <option value="nie">NIE</option>
                        <option value="nif">NIF</option>
                    </Select>
                </div>
    
                <div class="mb-3 col-8">
                    <input class="form-control" placeholder="" id="identificacion" type="text" hidden>
                </div>
            </div>
            
            <a href="/registro/validacion" class="btn btn-custom col-4" value="">Siguiente</a>
            <label for="identificacion" hidden>Identificación</label>
            <input type="text" hidden>
        </form>
        <div class="mb-3 iniciar_sesion_pregunta">
            <p>¿Ya tienes cuenta? <a href="/login">Iniciar sesión</a></p>
        </div>
    </div>
    </div>
    <?php include_once '../../components/footer.php'; ?>
    <script src="../../js/registro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>