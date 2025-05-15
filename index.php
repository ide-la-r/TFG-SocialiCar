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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include_once 'src/components/links.php'; ?>
</head>

<style>
    body {
        background-image: linear-gradient(to bottom right, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0)),
            url('src/img/fondo_index.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    .hero-section {
        min-height: 70vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .bienvenido {
        font-size: 4rem;
        color: #fff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        animation: aparecer 2s ease;
    }

    .socialicar {
        color: #ffeb3b;
        text-shadow: 0 0 15px rgba(255, 235, 59, 0.5);
        animation: flotar 3s ease-in-out infinite;
        font-size: 12rem;
        transform: rotate(-5deg);
        padding-top: 25px;
    }

   @keyframes flotar {
    0% {
        transform: rotate(-5deg) translateY(0);
    }

    50% {
        transform: rotate(-5deg) translateY(-10px);
    }

    100% {
        transform: rotate(-5deg) translateY(0);
    }
}


    .feature-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        border-radius: 2rem;
        transition: transform 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-5px);
    }

    .form-control-custom {
        border-radius: 1.5rem;
        padding: 1rem 1.5rem;
        border: 2px solid #dee2e6;
    }

    .btn-custom {
        border-radius: 1.5rem;
        padding: 1rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .how-it-works {
        background: rgba(196, 239, 242, 0.9);
        position: relative;
        overflow: hidden;
    }

    .car-animation {
        position: absolute;
        left: 5%;
        top: -30px;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
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

    @media (max-width: 768px) {
        .bienvenido {
            font-size: 2.5rem;
        }

        .socialicar {
            font-size: 3.5rem;
        }

        .hero-section {
            min-height: 50vh;
        }

        .car-animation {
            display: none;
        }
    }
</style>

<body>
    <!-- Navbar -->
    <?php include_once 'src/components/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="bienvenido mb-4">BIENVENIDO A</h1>
            <h1 class="socialicar">SocialiCar</h1>
        </div>
    </section>

    <!-- Search Form -->
    <form method="get" action="./src/pages/rentacar/mostrar_coches.php">
        <div class="container my-5">
            <div class="card feature-card p-3 p-lg-4 mx-auto border-0 shadow-lg">
                <div class="row g-3 justify-content-center">
                    <div class="col-12 col-md-4">
                        <select class="form-select form-control-custom">
                            <option>¿Dónde necesitas tu coche?</option>
                            <option value="malaga">Málaga</option>
                            <option value="granada">Granada</option>
                            <option value="madrid">Madrid</option>
                            <option value="valencia">Valencia</option>
                            <option value="barcelona">Barcelona</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <input type="text" class="form-control form-control-custom" placeholder="Fecha de inicio" onfocus="this.type='date'">
                    </div>
                    <div class="col-12 col-md-3">
                        <input type="text" class="form-control form-control-custom" placeholder="Fecha de fin" onfocus="this.type='date'">
                    </div>
                    <div class="col-12 col-md-2">
                        <button class="btn btn-primary btn-custom w-100">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Features -->
    <div class="container">
        <!-- Alquila tu coche -->
        <div class="row feature-card align-items-center g-5 my-5 p-4">
            <div class="col-12 col-lg-6 text-center">
                <img src="src/img/gente_feliz.webp" class="img-fluid">
            </div>
            <div class="col-12 col-lg-6">
                <h2 class="display-5 fw-bold mb-4">Alquila tu coche fácilmente 🚗</h2>
                <p class="lead mb-4">Conectamos dueños de vehículos con personas que necesitan un coche para sus viajes.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <span class="badge bg-success fs-6 py-2 px-3">✔️ 100% Seguro</span>
                    <span class="badge bg-primary fs-6 py-2 px-3">✔️ Precios flexibles</span>
                    <span class="badge bg-info fs-6 py-2 px-3">✔️ Soporte 24/7</span>
                </div>
            </div>
        </div>

        <!-- Gana dinero -->
        <div class="row feature-card align-items-center g-5 my-5 p-4">
            <div class="col-12 col-lg-6 order-lg-2 text-center">
                <img src="src/img/dinerito.png" class="img-fluid" style="max-width: 400px;">
            </div>
            <div class="col-12 col-lg-6">
                <h2 class="display-5 fw-bold mb-4">📱 Gana dinero con tu vehículo</h2>
                <ul class="list-unstyled fs-5">
                    <li class="mb-3">💵 Control total de precios</li>
                    <li class="mb-3">📅 Decide tu disponibilidad</li>
                    <li class="mb-3">🛡️ Seguro incluido</li>
                </ul>
            </div>
        </div>

        <!-- Reseñas -->
        <div class="row feature-card align-items-center g-5 my-5 p-4">
            <div class="col-12 col-md-4 text-center">
                <img src="src/img/reseñas.png" class="img-fluid" style="max-width: 200px;">
            </div>
            <div class="col-12 col-md-8">
                <h2 class="display-5 fw-bold mb-4">Sistema de reseñas y chat</h2>
                <p class="lead">Lee opiniones reales y comunícate en tiempo real con nuestra plataforma integrada.</p>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <section class="how-it-works py-5 my-5">
        <div class="car-animation">
            <img src="https://www.gifsanimados.org/data/media/67/coche-y-automovil-imagen-animada-0187.gif"
                alt="Coche animado"
                style="height: 120px;">
        </div>
        <div class="container text-center position-relative">
            <h2 class="display-4 fw-bold mb-4">¿Cómo funciona?</h2>
            <p class="lead mb-5">Simple y rápido en 3 pasos</p>
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <div class="card-body">
                            <h3 class="text-primary">1. Regístrate</h3>
                            <p>Crea tu cuenta en minutos</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <div class="card-body">
                            <h3 class="text-primary">2. Ofrece tu coche</h3>
                            <p>Configura tus preferencias</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <div class="card-body">
                            <h3 class="text-primary">3. Empieza a ganar</h3>
                            <p>Recibe solicitudes y renta</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/src/js/chatbot.js"></script>

    
    <!-- Footer -->
    <?php include_once 'src/components/footer-example.php'; ?>
</body>

</html>