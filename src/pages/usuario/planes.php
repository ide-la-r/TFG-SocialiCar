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

<body>
    <!-- Navbar -->
    <?php include_once '../../components/navbar.php'; ?>
    


    <!-- SUSCRIPCIONES -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row row-cols-1 row-cols-md-2 g-4 w-100">
            <!-- Tarjeta Plus -->
            <div class="col">
                <div class="card text-center h-100 shadow-lg border-primary">
                    <div class="card-body">
                        <h3 class="card-title text-primary">Suscripción Plus</h3>
                        <p class="card-text">Accede a vehículos estándar con precios competitivos y buen rendimiento.</p>
                        <h4 class="text-primary">9,99€/mes</h4>
                        <a href="#" class="btn btn-primary mt-3">Suscribirse</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Premium -->
            <div class="col">
                <div class="card text-center h-100 shadow-lg border-warning">
                    <div class="card-body">
                        <h3 class="card-title text-warning">Suscripción Premium</h3>
                        <p class="card-text">Accede a vehículos exclusivos, ventajas adicionales y atención preferente.</p>
                        <h4 class="text-warning">19,99€/mes</h4>
                        <a href="#" class="btn btn-warning mt-3 text-white">Suscribirse</a>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Footer -->
    <?php include_once '../../components/footer.php'; ?>
</body>

</html>