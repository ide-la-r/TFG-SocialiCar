<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
require(__DIR__ . "/src/config/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SocialiCar - Comparte tu coche</title>
    <link rel="icon" href="src/img/favicon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <?php include_once 'src/components/links.php'; ?>

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

        @media (max-width: 1200px) {
            .hero-section {
                min-height: 60vh;
            }
        }

        @media (max-width: 992px) {
            .hero-section {
                min-height: 50vh;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                min-height: 40vh;
            }
        }

        @media (max-width: 576px) {
            .hero-section {
                min-height: 30vh;
            }
        }

        .bienvenido {
            font-size: clamp(2rem, 5vw, 4rem);
            color: #fff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            animation: aparecer 2s ease;
            padding-top: 60px;
        }

        .socialicar {
            color: #ffeb3b;
            text-shadow: 0 0 15px rgba(255, 235, 59, 0.5);
            animation: flotar 3s ease-in-out infinite;
            transform: rotate(-5deg);
            padding-top: 25px;
            font-size: clamp(4.5rem, 15vw, 16rem);
            padding-bottom: 10px;
            position: relative;
            
        }

        /* efecto espejo */
        .socialicar::after {
            content: attr(class);
            position: absolute;
            top: 10%;
            left: 0;
            right: 0;
            font-size: inherit;
            font-family: inherit;
            color: rgb(255, 238, 87);
            opacity: 0.35;
            transform: scaleY(-1.5);
            user-select: none;
            filter: blur(16px);
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
            left: 1%;
            top: -30px;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }

        .car-gif {
            height: auto;
            max-height: clamp(60px, 10vw, 120px);
            width: auto;
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

        .fondo-difuminado-lados {
            background: rgba(255, 255, 255, 0.85);
            padding: 20px;
            border-radius: 15px;

            /* difumina los lados */
            mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        }

        @media (max-width: 991.98px) {
            .feature-card {
                max-width: 900px;
                padding: 1rem;
                margin-top: 1.5rem;
                margin-bottom: 1.5rem;
            }
        }

        @media (max-width: 575.98px) {
            .feature-card {
                padding: 0.5rem;
                margin-top: 1rem;
                margin-bottom: 1rem;
            }

            .feature-card p {
                text-align: center !important;
                white-space: normal;
                word-break: break-word;
            }
        }

        /* LOGO YURI */
        .yuriLogo {
            position: fixed;
            cursor: default;
            margin-left: 2px;
            margin-top: 200px;
            z-index: 1000;
        }

        .yuriLogo img {
            width: 20px;
            height: 20px;
            object-fit: contain;
        }

        .busqueda {
            animation: aparecer 1s ease;
        }
    </style>
</head>

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
    
    <a class="yuriLogo" href="/src/pages/yuri/yuri">
        <img
            src="/src/img/yuriasomada.png"
            alt="Yuri"
            loading="lazy" />
    </a>

    <!-- Search Form -->
    <form method="get" action="./src/pages/rentacar/mostrar_coches.php" class="mt-5 busqueda">
        <div class="container my-5">
            <div class="p-3 p-lg-4 border-0 shadow-lg bg-white bg-opacity-75 rounded-5">
                <div class="row g-3 justify-content-center">
                    <div class="col-12 col-md-4">
                        <select class="form-select form-control-custom" name="location">
                            <option>¿Dónde necesitas tu coche?</option>
                            <option value="malaga">Málaga</option>
                            <option value="granada">Granada</option>
                            <option value="madrid">Madrid</option>
                            <option value="valencia">Valencia</option>
                            <option value="barcelona">Barcelona</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <input type="text" name="start_date" class="form-control form-control-custom" placeholder="Fecha de inicio" onfocus="this.type='date'" />
                    </div>
                    <div class="col-12 col-md-3">
                        <input type="text" name="end_date" class="form-control form-control-custom" placeholder="Fecha de fin" onfocus="this.type='date'" />
                    </div>
                    <div class="col-12 col-md-2">
                        <button class="btn btn-primary btn-custom w-100" style="padding: 1rem 2rem">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Features -->
    <div class="container my-5">

        <!-- Alquila tu coche -->
        <div class="row feature-card align-items-center justify-content-center g-5 my-5 p-4" style="opacity: 0.90; max-width: 1100px; margin: auto;">
            <div class="col-12 col-lg-6 d-flex justify-content-center">
                <img src="src/img/gente_feliz.webp" class="img-fluid rounded w-100" />
            </div>
            <div class="col-12 col-lg-6 p-3 d-flex flex-column justify-content-center text-center text-lg-start">
                <h2 class="display-5 fw-bold mb-4">Alquila tu coche fácilmente 🚗</h2>
                <p class="lead mb-4">Conectamos dueños de vehículos con personas que necesitan un coche para sus viajes.</p>
                <div class="d-flex gap-3 flex-wrap justify-content-center justify-content-lg-start">
                    <span class="badge bg-success fs-6 py-2 px-3">✔️ 100% Seguro</span>
                    <span class="badge bg-primary fs-6 py-2 px-3">✔️ Precios flexibles</span>
                    <span class="badge bg-info fs-6 py-2 px-3">✔️ Soporte 24/7</span>
                </div>
            </div>
        </div>

        <!-- Gana dinero -->
        <div class="row feature-card align-items-center justify-content-center g-5 my-5 p-4" style="opacity: 0.90; max-width: 900px; margin: auto;">
            <div class="col-12 col-lg-6 order-lg-2 d-flex justify-content-center">
                <img src="src/img/dinerito.png" class="img-fluid rounded w-75 pb-5" alt="Gana dinero con tu vehículo" />
            </div>
            <div class="col-12 col-lg-6 d-flex flex-column justify-content-center px-3 px-lg-0" style="word-wrap: break-word;">
                <h2 class="display-5 fw-bold mb-4 text-center">📱 Gana dinero con tu vehículo</h2>
                <ul class="list-unstyled fs-5 ps-4 ps-lg-0 text-start mx-auto" style="max-width: 400px;">
                    <li class="mb-3">💵 Control total de precios</li>
                    <li class="mb-3">📅 Decide tu disponibilidad</li>
                    <li class="mb-3">🛡️ Seguro incluido</li>
                </ul>
            </div>
        </div>

        <!-- Reseñas -->
        <div class="container my-5">
            <div class="row feature-card align-items-center justify-content-center g-5 my-5 p-4" style="opacity: 0.90; max-width: 750px; margin: auto;">
                <div class="col-12 col-md-4 d-flex justify-content-center">
                    <img src="src/img/reseñas.png" class="img-fluid rounded w-75 mb-5" />
                </div>
                <div class="col-12 col-md-8 d-flex flex-column justify-content-center text-center text-md-start">
                    <h2 class="display-5 fw-bold mb-4 p-3">Sistema de reseñas y chat</h2>
                    <p class="lead p-3">Lee opiniones reales y comunícate en tiempo real con nuestra plataforma integrada.</p>
                </div>
            </div>
        </div>

    </div>

    <!-- How It Works -->
    <section class="how-it-works py-5 my-5">
        <div class="container text-center">
            <h2 class="display-4 fw-bold mb-4">
                ¿Cómo funciona?
                <img style="width: 100px;" src="https://www.gifsanimados.org/data/media/67/coche-y-automovil-imagen-animada-0187.gif" alt="gif coche animado" />
            </h2>
            <div class="row justify-content-center text-center g-5">
                <div class="row justify-content-center g-5">
                    <div class="row">
                        <div class="col-12 col-md-4 d-flex">
                            <div class="d-flex flex-column align-items-center fondo-difuminado-lados flex-fill">
                                <div class="rounded-circle text-white d-flex justify-content-center align-items-center mb-3" style="width: 80px; height: 80px; font-size: 1.5rem; background-color: rgb(160, 115, 255);">
                                    1
                                </div>
                                <h2 class="fw-bold">Regístrate</h2>
                                <p>Crea tu cuenta en minutos</p>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 d-flex">
                            <div class="d-flex flex-column align-items-center fondo-difuminado-lados flex-fill">
                                <div class="rounded-circle text-white d-flex justify-content-center align-items-center mb-3" style="width: 80px; height: 80px; font-size: 1.5rem; background-color: rgb(197, 255, 131);">
                                    2
                                </div>
                                <h2 class="fw-bold">Ofrece tu coche</h2>
                                <p>Configura tus preferencias</p>
                            </div>
                        </div>


                        <div class="col-12 col-md-4 d-flex position-relative">
                            <div class="d-flex flex-column align-items-center fondo-difuminado-lados flex-fill">
                                <div class="rounded-circle bg-info text-white d-flex justify-content-center align-items-center mb-3" style="width: 80px; height: 80px; font-size: 1.5rem;">
                                    3
                                </div>
                                <h2 class="fw-bold">Empieza a ganar</h2>
                                <p>Recibe solicitudes y renta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include_once 'src/components/footer-example.php'; ?>

    <!-- Scripts al final para mejor performance -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/src/js/conversa_ia.js"></script>
</body>

</html>