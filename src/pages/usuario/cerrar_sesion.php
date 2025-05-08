<?php
    session_start();
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    require(__DIR__ . "/../../config/conexion.php");

    if (isset($_SESSION["usuario"])) {
        $usuario = $_SESSION["usuario"]["identificacion"];

        // Actualizar el estado del usuario a 0 (offline)
        $sql = $_conexion->prepare("UPDATE usuario SET estado = 0 WHERE identificacion = ?");
        $sql->bind_param("s", $usuario);
        $sql->execute();
        $sql->close();

        // Destruir la sesión
        session_destroy();
        header("location: iniciar_sesion.php");
        exit;

    } else {
        // Redirigir si no hay sesión iniciada
        header("Location: ../../../");
        exit();
    }
?>