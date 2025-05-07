<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descarga la app</title>
    <?php include_once '../../components/links.php'; ?>
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
    <h3 class="fw-bold text-center" style="color: #595959;">Actualmente no disponemos de una app, pero si te interesa, no dudes en contactarnos para saber mas sobre la app y su desarrollo:</h3>
    <a href="mailto:socialicar.rentacar@gmail.com" class="text-decoration-none" style="color: #0099cc; font-weight: 500;">socialicar.rentacar@gmail.com</a>
</div>

<?php include_once '../../components/footer.php';?>
</body>
</html>