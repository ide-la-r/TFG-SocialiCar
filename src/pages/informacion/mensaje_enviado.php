<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Easter Egg</title>
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
        .centrado-contenedor {
            min-height: 50vh;
            display: flex;
            align-items: center;
            justify-content: center;

        }
        .mensaje-card {
            max-width: 500px;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            text-align: center;
        }
        .mensaje-card img {
            width: 120px;
            margin-bottom: 20px;
        }
        .btn-primary{
            background-color: #6BBFBF;
            border-color: #6BBFBF;
        }
        .btn-primary:hover {
            background-color: #5a9b9b;
            border-color: #5a9b9b;
        }
    </style>
</head>
<body>
    <?php include_once '../../components/navbar.php'; ?>

    <div class="centrado-contenedor">
        <div class="mensaje-card">
            <img src="/src/img/LogoSocialicar.png" alt="Logo SocialiCar">
            <h2 class="text-success">¡Mensaje enviado correctamente!</h2>
            <p>Gracias por contactarnos. Hemos recibido tu mensaje y te responderemos lo antes posible.</p>
            <a href="/src/pages/informacion/contacto" class="btn btn-primary mt-3">Volver</a>
        </div>
    </div>

    <?php include_once '../../components/footer-example.php'; ?>
</body>
</html>