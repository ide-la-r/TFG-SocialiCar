<?php
    $env = parse_ini_file(__DIR__ . '/../../.env');
    $_servidor = $env['BBDD_SERVER'];
    $_usuario = $env['BBDD_USER'];
    $_contrasena = $env['BBDD_PASS'];
    $_base_de_datos = $env['BBDD_NAME'];

    $_conexion = new Mysqli($_servidor, $_usuario, $_contrasena, $_base_de_datos);
    
    if ($_conexion -> connect_error) {
        die("Error de conexión: " . $_conexion->connect_error);
    } else {
        echo "<script>console.log('Conexión exitosa');</script>";
    }
?>