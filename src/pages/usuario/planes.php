<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>
    <?php 
        include_once '../../components/links.php'; 
        require(__DIR__ . "/../../config/conexion.php");
    ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="../../../src/styles/planes.css">
</head>

<body>
    <!-- navbar -->
    <?php include_once '../../components/navbar.php'; ?>
    <?php
    $sub_basica = 9.99;
    $sub_premium = 19.99;
    ?>

    <!-- video -->
    <div class="video-container">
        <video autoplay muted loop playsinline class="video">
            <source src="../../video/socialicar_1.mp4" type="video/mp4">
            Tu navegador no soporta vídeos HTML5.
        </video>
        <div class="oscuro"></div>


        <!-- SUSCRIPCIONES -->
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="row row-cols-1 row-cols-md-2 justify-content-center g-4 w-75">

                <!-- basica -->
                <div class="col d-flex justify-content-center">
                    <div class="card-container">
                        <div class="card text-center first-card">
                            <div class="card-body">
                                <h3 class="card-title mb-3 fs-1" style="color: rgba(255, 255, 255, 0.99);">
                                    Suscripción Básica
                                </h3>
                                <p class="card-text" style="color: white">
                                    <span class="badge bg-primary mb-2">OFERTAS EXCLUSIVAS</span><br>
                                    Disfruta de descuentos exclusivos y posiciona tu vehículo en las primeras posiciones una vez por semana.
                                </p>
                                <h4 class="mt-3 precio" style="color: rgba(101, 255, 81, 0.99); font-size: 2rem;">9,99€/mes</h4>
                                <a href="../pago/iniciar_pago.php?tipo=basica" class="btn btn-outline-primary mt-3 boton2" style="color: white; background-color: rgba(17, 112, 255, 0.99)">Suscribirse</a>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- premium -->
                <div class="col d-flex justify-content-center">
                    <div class="card-container">
                        <div class="card text-center second-card">
                            <div class="card-body">
                                <h3 class="card-title mb-3 fs-1 neon" style="color: rgba(255, 255, 255, 0.99);">
                                    Suscripción Premium
                                </h3>
                                <p class="card-text mb-4" style="color: white;">
                                    <span class="badge bg-warning mb-2">VEHÍCULOS EXCLUSIVOS</span><br>
                                    - Posiciona tus vehículos siempre en las primeras posiciones <br>
                                    - Accede a vehículos reservados solo para nuestros usuarios Premium <br>
                                    - Disfruta de reservas prioritarias <br>
                                    - Ofertas y descuentos únicos.
                                </p>
                                <h4 class="my-4 precio" style="color: rgba(101, 255, 81, 0.99); font-size: 2rem;">19,99€/mes</h4>
                                <a href="../pago/iniciar_pago.php?tipo=premium" class="btn btn-outline-warning boton1" style="background-color:rgba(242, 255, 0, 0.18); color: white">Suscribirse</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- Footer -->
    <?php include_once '../../components/footer-example.php';?>
    <script src="/src/js/chatbot.js"></script>
</body>

</html>