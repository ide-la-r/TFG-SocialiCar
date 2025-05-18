<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        session_start();
        require(__DIR__ . "/../../config/conexion.php");
    ?>
    <style>
        body {
            background: linear-gradient(135deg, #f0f0f0, #F2F2F2);
            color: #595959;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }
        .error-container {
            background: rgba(211, 211, 211, 0.50);
            border-radius: 10px;
            padding: 3rem;
            max-width: 600px;
            margin: auto;
            margin-top: 50px;
            margin-bottom: 40px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .error-title {
            font-size: 6rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .error-message {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }
        .error-img {
            width: 100%;
            max-width: 300px;
            height: 300px;
            margin: 0 auto 2rem;
        }
        .btn-primary {
            background-color: #6BBFBF;
            border-color: #595959;
        }
        .btn-primary:hover {
            background-color: #B0D5D9;
            border-color: #595959;
        }
    </style>
</head>

<body>
    <?php include_once '../../components/navbar.php'; ?>
    <div class="error-container">
        <div class="error-title">404</div>
        <div class="error-message">¡Oops! La página que buscas no existe.</div>
        <dotlottie-player class="error-img" src="https://lottie.host/89c452c8-2ded-4f4d-a915-4e820ddb6e53/oc4yS0xyih.lottie" background="transparent" speed="0.6" autoplay></dotlottie-player>
        <a href="/" class="btn btn-primary btn-lg">Volver al inicio</a>
    </div>
    
    <?php include_once '../../components/footer-example.php'; ?>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
</body>

</html>