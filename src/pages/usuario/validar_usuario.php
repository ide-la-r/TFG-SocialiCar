<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="../../../src/styles/index.css">
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    require(__DIR__ . "/../../config/conexion.php");

    session_start();
    ?>
    <style>
        .error {
            color: #e03131;
            font-size: 1em;
        }

        
        body {
            background-image: url('../../img/light-blue-background-13.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            position: relative;
            min-height: 100vh;
            display: flex;
            background-position: center;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <?php include_once '../../components/navbar.php'; ?>
        
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $codigo_real = $_SESSION["usuario"]["codigo"];
            $codigo_usuario = $_POST['codigo'];
            
            if (empty($codigo_usuario)) {
                $err_codigo = "Debes introducir el codigo de verificación.";
            } else {
                if ($codigo_usuario != $codigo_real) {
                    $err_codigo = "El código de verificación es incorrecto.";
                } else{
                    $codigo = $codigo_usuario;
                }
            }
        }
    ?>
    <div class="container mt-5 pt-5 d-flex justify-content-center align-items-center">
        <div class="card text-center card_registro w-100 p-4 rounded-4 shadow mx-auto" style="max-width: 420px;">
            <h1 class="register pt-2 pb-3">Confirmar correo electrónico</h1>
            <form action="" method="post">
                <div class="row gy-3">

                    <div class="mb-2 col-12">
                        <div class="form-floating">
                            <?php $correo_usuario = $_SESSION["usuario"]["correo"]; ?>
                            <input class="form-control" type="email" id="correo" placeholder="Correo electrónico*" name="correo" value="<?php echo $correo_usuario; ?>" disabled>
                            <label for="correo">Correo</label>
                        </div>

                    </div>

                    <div class="mb-2 col-12">
                        <div class="form-floating">
                            <input id="codigo" class="form-control <?php if (isset($err_codigo)) echo 'is-invalid'; ?>" type="text" placeholder="Código*" name="codigo" value="<?php if (isset($codigo_usuario)) echo $codigo_usuario; ?>">
                            <label for="codigo">Código</label>
                            <?php if (isset($err_codigo)) echo "<span class='error'>$err_codigo</span>"; ?>
                        </div>

                    </div>

                    <div class="col-12 mt-3">
                        <input type="submit" class="btn btn-primary w-100" value="Confirmar">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include_once '../../components/footer-example.php'; ?>


    <?php
        if (isset($codigo)) {
            // Supongamos que la identificación está guardada en la sesión
            $identificacion = $_SESSION["usuario"]["identificacion"];
        
            $actualizar_usuario = $_conexion->prepare("UPDATE usuario SET verificado = 1 WHERE identificacion = ?");
            $actualizar_usuario->bind_param("s", $identificacion);
            $actualizar_usuario->execute();
        
            if ($actualizar_usuario->affected_rows > 0) {
                
                echo "<script>window.location.href = '/';</script>";
                exit();
            } else {
                echo "<p class='error'>No se pudo actualizar el estado de verificación.</p>";
            }
        }
    ?>
</body>
</html>