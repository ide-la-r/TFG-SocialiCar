<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabaja con nosotros</title>
    <?php 
    include_once '../../components/links.php'; 
    require(__DIR__ . "/../../config/conexion.php");
    ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        session_start();
    ?>
</head>
<body>
<?php include_once '../../components/navbar.php'; ?>

<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh;">
    <!-- Imagen de referencia, reemplaza src por tu imagen -->
    <img src="../../../src/img/mascota.png" alt="Aqui va la imagen de nuestra mascota xD" style="max-width:200px; margin-bottom: 20px; display:block;" />
    <h3 class="fw-bold text-center" style="color: #595959;">No tenemos ningún puesto abierto ahora mismo</h3>
    <p class="text-center" style="margin-bottom: 0;">¡Nos encantaría conocerte de todas formas! Puedes escribirnos a:</p>
    <a href="mailto:socialicar.rentacar@gmail.com" class="text-decoration-none" style="color: #0099cc; font-weight: 500;">socialicar.rentacar@gmail.com</a>
</div>

<?php include_once '../../components/footer-example.php';?>
</body>
</html>