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
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
</head>

<style>
    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .video-container {
        position: relative;
        width: 100%;
        height: 100vh;
        z-index: 0;
    }

    .video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
    }

    .oscuro {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }

    .card-container {
        position: relative;
        height: 180px;
        width: 320px;
        margin: 15px 0;
    }

    .card {
        width: 100%;
        height: 100%;
        border-radius: 15px;
        background: linear-gradient(135deg, #111 48%, #444 52%);
        position: absolute;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6);
        border: 2px solid rgba(255, 255, 255, 0.6);
        padding: 20px;
        animation: aparecer 0.8s ease-out forwards;
        animation-delay: 0.6s;
        transition: all 0.3s ease-in-out;
        z-index: 23;
        margin-top: -15vh;
    }

    @keyframes aparecer {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .first-card:hover, .second-card:hover {
        height: 480px;
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        z-index: 24;
    }

    .btn {
        margin: 0 auto;
        border-radius: 25px !important;
    }

</style>

<body>
    <!-- navbar -->
    <?php include_once '../../components/navbar.php'; ?>

    <!-- video -->
    <div class="video-container">
        <video autoplay muted loop playsinline class="video">
            <source src="../../video/socialicar_1.mp4" type="video/mp4">
            Tu navegador no soporta vídeos HTML5.
        </video>
        <div class="oscuro"></div>

        <!-- SUSCRIPCIONES MODIFICADO -->
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
                                <h4 class="mt-3" style="color: rgba(101, 255, 81, 0.99)">9,99€/mes</h4>
                                <a href="" class="btn btn-outline-primary mt-3">Suscribirse</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- premium -->
                <div class="col d-flex justify-content-center">
                    <div class="card-container">
                        <div class="card text-center second-card">
                            <div class="card-body">
                                <h3 class="card-title mb-3 fs-1" style="color: rgba(255, 255, 255, 0.99);">
                                    Suscripción Premium
                                </h3>
                                <p class="card-text" style="color: white">
                                    <span class="badge bg-warning mb-2">VEHÍCULOS EXCLUSIVOS</span><br>
                                    Posiciona tus vehículos siempre en las primeras posiciones, accede a vehículos reservados solo para nuestros usuarios Premium, disfruta de reservas prioritarias, ofertas y descuentos únicos.
                                </p>
                                <h4 class="mt-3" style="color: rgba(101, 255, 81, 0.99)">19,99€/mes</h4>
                                <a href="" class="btn btn-outline-warning mt-3">Suscribirse</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once '../../components/footer.php'; ?>
</body>

</html>