<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SocialiCar - Comparte tu coche</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

<?php

// Configuración de errores
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Definir la URL base de la aplicación
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/socialicar/');

session_start();
?>