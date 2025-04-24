<?php
    $_servidor = "127.0.0.1";
    $_usuario = "root";
    $_contrasena = "";
    $_base_de_datos = "socialicar";

    $_conexion = new Mysqli($_servidor, $_usuario, $_contrasena, $_base_de_datos);
    
    if ($_conexion -> connect_error) {
        die("Error de conexión: " . $_conexion->connect_error);
    } else {
        echo "<script>console.log('Conexión exitosa');</script>";
    }
?>