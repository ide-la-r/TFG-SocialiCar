<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
require(__DIR__ . "/src/config/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Comparte tu coche</title>

    <link rel="icon" href="src/img/favicon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <?php
    include_once 'src/components/links.php';
    ?>
</head>

<style>
    body {
        background-image:
            linear-gradient(to bottom right, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0)),
            url('src/img/fondo_index.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
    }

    .bienvenido {
        font-size: 6rem;
        text-align: center;
        color: #ffffff;
        margin: 2rem 0;
        padding: 1.5rem 0;
        animation: aparecer 1.5s ease-out;
    }

    .socialicar {
        color: rgb(255, 245, 102);
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        display: inline-block;
        transform: rotate(-5deg);
        animation: flotar 6s ease-in-out infinite;
        font-size: 15rem;
        margin-top: -5vh;
    }


    @keyframes aparecer {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes flotar {
        0% {
            transform: translateY(0) rotate(-5deg);
        }

        50% {
            transform: translateY(-15px) rotate(-5deg);
        }

        100% {
            transform: translateY(0) rotate(-5deg);
        }
    }

    .form-select {
        border-radius: 25px !important;
        padding: 8px 20px;
    }

    .form-control {
        border-radius: 25px !important;
        padding: 8px 20px;
    }

    .btn {
        border-radius: 25px !important;
        transition: all 0.3s ease;
    }
</style>

<body>
    <!-- Navbar -->
    <?php include_once 'src/components/navbar.php'; ?>

    <div style="margin-top: 10vh; margin-bottom: 15vh; height: 40vh; text-align: center;">
        <h1 class="bienvenido">BIENVENIDO A</h1>
        <h1 class="socialicar">SocialiCar</h1>
    </div>


    <style>


    </style>
    <!-- buscador -->
    <div class="container my-5">
        <div class="card p-4 shadow mx-auto" style="max-width: 120vh; border-radius: 50px !important;">
            <div class="row g-3 justify-content-center">
                <!-- ubicacion -->
                <div class="col-md-4">
                    <select id="ciudad" class="form-select">
                        <option selected>¿Dónde necesitas tu coche?</option>
                        <option value="1">Málaga</option>
                        <option value="2">Granada</option>
                        <option value="3">Madrid</option>
                        <option value="4">Valencia</option>
                        <option value="5">Barcelona</option>
                    </select>
                </div>
                <!-- fechas -->
                <div class="col-md-3">
                    <input type="text" id="fecha_inicio" class="form-control" placeholder="Fecha de inicio" onfocus="this.type='date';">
                </div>

                <div class="col-md-3">
                    <input type="text" id="fecha_fin" class="form-control" placeholder="Fecha de fin" onfocus="this.type='date';">
                </div>

                <!-- buscar -->
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100 py-2">Buscar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- alquila tu coche-->
    <div class="container my-5" style="background-color: rgba(255, 255, 255, 0.72); border-radius: 70px; width: 90%">
        <div class="row justify-content-center align-items-center">
            <!-- imagen -->
            <div class="col-md-6 mb-4 mb-md-0 text-center">
                <img src="src/img/gente_feliz.webp" class="img" style="height: 370px; width: 500px;">
            </div>

            <!-- texto -->
            <div class="col-md-6 ps-md-5 text-start">
                <h2 class="display-5 fw-bold mb-3">Alquila tu coche fácilmente 🚗</h2>
                <p class="mt-5">En Socialicar conectamos dueños de vehículos con personas que buscan un coche para sus vacaciones, viajes, fines de semana...</p>
                <p class="mt-2">✔️ 100% Seguro | ✔️ Precios flexibles | ✔️ Soporte 24/7</p>
            </div>
        </div>
    </div>


    <!-- gana dinero-->
    <div class="container my-5 py-4 " style="background-color: rgba(255, 255, 255, 0.72); border-radius: 70px; width: 70%; margin-top: 15vh">
        <div class="row justify-content-center align-items-center text-center">
            <!-- texto -->
            <div class="col-md-6">
                <h2 class="display-5 fw-bold mb-3" style="width: 150%;">📱 Gana dinero con tu vehículo</h2>
                <p class="mt-5">
                    ¿Tienes un coche que no usas? ¡Con SocialiCar conviértelo en ingresos extras!:
                    <span class="d-block mt-5">
                        💵 Control total de precios<br>
                        📅 Decide tu disponibilidad<br>
                        🛡️ Seguro incluido
                    </span>
                </p>
            </div>

            <!-- imagen -->
            <div class="col-md-6 mt-md-0">
                <img
                    src="src/img/dinerito.png"
                    style="transform: rotate(2deg); height: 300px; width: 300px;">
            </div>
        </div>
    </div>


    <!-- reseñas -->
    <div class="container my-5 pt-3" style="background-color: rgba(255, 255, 255, 0.72); border-radius: 70px; width: 65%">
        <div class="row justify-content-center align-items-center text-center">
            <!-- imagen -->
            <div class="col-md-5 mb-4 mb-md-0 d-flex justify-content-center">
                <img src="src/img/reseñas.png" class="img" style="height: 200px; width: 220px;">
            </div>

            <!-- texto -->
            <div class="col-md-5 ps-md-5 text-start">
                <h2 class="display-5 fw-bold mb-3">Sistema de reseñas y chat en vivo</h2>
                <p class="mt-5">En nuestra plataforma puedes leer reseñas de otros usuarios y participar en un chat en vivo para resolver dudas o compartir experiencias sobre el alquiler de vehículos.</p>
            </div>
        </div>
    </div>

    <!-- como funciona -->
    <section id="funcionamiento" class="py-5" style="background-color: rgba(196, 239, 242, 0.8) ; position: relative; margin-bottom: 3vh">
        <div style="position: absolute; left: 25vh; top: 20px;">
            <a href="https://www.gifsanimados.org/cat-coches-y-automoviles-67.htm">
                <img src="https://www.gifsanimados.org/data/media/67/coche-y-automovil-imagen-animada-0187.gif" alt="coche-y-automovil-imagen-animada-0187" style="height: 20vh;" />
            </a>
        </div>

        <div class="container text-center">
            <h2>¿Cómo funciona?</h2>
            <p class="pb-5">¡Es fácil! Solo sigue estos pasos</p>
            <div class="row">
                <div class="col-md-4">
                    <h4>1. Regístrate</h4>
                    <p>Crea tu cuenta en SocialiCar para formar parte de nuestra comunidad.</p>
                </div>
                <div class="col-md-4">
                    <h4>2. Alquila tu propio coche</h4>
                    <p>¡Empieza a ganar dinero alquilando tu coche sin complicaciones!</p>
                </div>
                <div class="col-md-4">
                    <h4>3. Alquila cualquier coche</h4>
                    <p>Alquila un coche para diario, tus vacaciones, fin de semana... ¡o alquila el coche de tus sueños!</p>
                </div>
            </div>
        </div>
    </section>
    <script src="/src/js/chatbot.js"></script>



    <!-- Footer -->
    <?php include_once 'src/components/footer-example.php'; ?>
</body>

</html>