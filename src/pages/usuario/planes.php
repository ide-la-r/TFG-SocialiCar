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

    .video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1;
    }

    .card {
        position: relative;
        z-index: 1;
        height: 70vh;
        width: 50vh;
        border-radius: 20px;
        opacity: 0;
        transform: translateY(30px);
        animation: aparecer 0.8s ease-out forwards;
        animation-delay: 0.4s;
        transition: transform 0.3s;
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

    .first-card {
        background: linear-gradient(to bottom, rgb(145, 198, 255), #ffffff);
    }

    .second-card {
        background: linear-gradient(to bottom, rgb(255, 236, 129), #ffffff);
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
    <video autoplay muted loop playsinline class="video">
        <source src="../../video/socialicar_1.mp4" type="video/mp4">
        Tu navegador no soporta vídeos HTML5.
    </video>


    <!-- SUSCRIPCIONES -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row row-cols-1 row-cols-md-2 justify-content-center g-4 w-75">

            <!-- basica -->
            <div class="col d-flex justify-content-center">
                <div class="card text-center shadow-lg border-primary border-4 hover-shadow transition first-card">
                    <div class="card-body">
                        <h3 class="card-title text-primary mb-3 fs-1">
                            Suscripción Básica
                        </h3>
                        <p class="card-text">
                            <span class="badge bg-primary mb-2">OFERTAS EXCLUSIVAS</span><br>
                            Disfruta de descuentos exclusivos y posiciona tu vehículo en las primeras posiciones una vez por semana.
                        </p>
                        <h4 class="text-primary mt-3">9,99€/mes</h4>
                        <a href="" class="btn btn-outline-primary mt-3">Suscribirse</a>
                    </div>
                </div>
            </div>

            <!-- premium -->
            <div class="col d-flex justify-content-center">
                <div class="card text-center shadow-lg border-warning border-4 hover-shadow transition custom-card second-card">
                    <div class="card-body">
                        <h3 class="card-title text-warning mb-3 fs-1">
                            Suscripción Premium
                        </h3>
                        <p class="card-text">
                            <span class="badge bg-warning text-dark mb-2">VEHÍCULOS EXCLUSIVOS</span><br>
                            Posiciona tus vehículos siempre en las primeras posiciones, accede a vehículos reservados solo para nuestros usuarios Premium, disfruta de reservas prioritarias, ofertas y descuentos únicos.
                        </p>
                        <h4 class="text-warning mt-3">19,99€/mes</h4>
                        <a href="" class="btn btn-outline-warning mt-3">Suscribirse</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once '../../components/footer.php'; ?>
</body>

</html>