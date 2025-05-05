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
        background-image:
            linear-gradient(to bottom right, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0)),
            url('../../img/fondo_para_socialicar.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
    }

    .card {
        height: 70vh;
        width: 50vh;
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
        width: 15vh; 
        margin: 0 auto; 
    }
</style>

<body>
    <!-- Navbar -->
    <?php include_once '../../components/navbar.php'; ?>


    <!-- SUSCRIPCIONES -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row row-cols-1 row-cols-md-2 justify-content-center g-4 w-75">

            <!-- Tarjeta Básica (Primera tarjeta) -->
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

            <!-- Tarjeta Premium (Segunda tarjeta) -->
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