<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SocialiCar - Planes de Suscripción</title>
    <?php
    include_once '../../components/links.php';
    require(__DIR__ . "/../../config/conexion.php");
    ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="../../../src/styles/planes.css">
</head>
<style>
    /* NO TOQUEIS ESTO POR FAVOR */
    .wave-container {
        height: 150px;
        margin-top: -150px;
    }

    .hero-section {
        height: 130vh;
    }

    /* Siempre visible en pantallas grandes */
    .plan-body {
        display: block;
    }

    /* Estilo de flecha */
    .dropdown-arrow {
        font-size: 1.2rem;
        color: black;
        margin-top: 0.5rem;
    }

    /* Solo en pantallas pequeñas */
    @media (max-width: 767px) {
        .plan-body {
            display: none;
        }

        .plan-card.open .plan-body {
            display: block;
        }

        .dropdown-arrow {
            display: inline-block;
            transition: transform 0.3s;
        }

        .plan-card.open .dropdown-arrow {
            transform: rotate(180deg);
            /* Gira la flecha al abrir */
        }

        .plan-header {
            cursor: pointer;
        }


        .section-title {
            margin-top: -10vh;
        }
    }
</style>

<body>
    <!-- Navbar -->
    <?php include_once '../../components/navbar.php'; ?>

    <!-- Hero Section with Video Background -->
    <section class="hero-section">
        <video autoplay muted loop playsinline class="hero-video">
            <source src="../../video/socialicar_1.mp4" type="video/mp4" />
            Tu navegador no soporta vídeos HTML5.
        </video>
        <div class="video-overlay"></div>

        <!-- Plans Section -->
        <div class="container plans-container cards-section" style="margin-top: 5vh;">
            <div class="row">
                <div
                    class="col-12">
                    <h1 class="section-title">Planes de Suscripción</h1>
                </div>
            </div>
            <div class="row justify-content-center g-4">
                <!-- Plan Básico -->
                <div class="col-md-5 col-lg-4">
                    <div class="plan-card basic-plan">
                        <div class="plan-header" onclick="togglePlan(this)">
                            <h3 class="plan-title">Plan Básico</h3>
                            <div class="plan-price">6,99€ <span>/ mes</span></div>
                            <div class="dropdown-arrow">▼</div>
                        </div>
                        <div class="plan-body">
                            <ul class="plan-features">
                                <li><i class="fas fa-check-circle feature-icon" style="color: #C4EEF2"></i> Localización de tu vehículo</li>
                                <li><i class="fas fa-check-circle feature-icon" style="color: #C4EEF2"></i> Promociona hasta 3 anuncios</li>
                                <li><i class="fas fa-times-circle feature-icon" style="color: #ff4757"></i> Sin acceso a soporte premium</li>
                                <li><i class="fas fa-times-circle feature-icon" style="color: #ff4757"></i> Sin prioridad en las reservas</li>
                                <li><i class="fas fa-times-circle feature-icon" style="color: #ff4757"></i> Sin ofertas exclusivas</li>
                            </ul>
                            <a href="../pago/iniciar_pago.php?tipo=basica" class="btn btn-basic btn-plan" style="background-color: #C4EEF2; color:#333; margin-top:12vh">Suscribirse</a>
                        </div>
                    </div>
                </div>


                <!-- Plan Premium -->
                <div class="col-md-5 col-lg-4 position-relative">
                    <div class="recommended-badge animate__animated animate__pulse animate__infinite">Recomendado</div>
                    <div class="plan-card premium-plan">
                        <div class="plan-header" onclick="togglePlan(this)">
                            <h3 class="plan-title">Plan Premium</h3>
                            <div class="plan-price">
                                19,99€ <span>/ mes</span>
                            </div>
                            <div class="dropdown-arrow">▼</div>
                        </div>
                        <div class="plan-body">
                            <ul class="plan-features">
                                <li><i class="fas fa-check-circle feature-icon" style="color: rgba(250, 113, 255)"></i>Localización de tu vehículo</li>
                                <li><i class="fas fa-check-circle feature-icon" style="color: rgb(250, 113, 255)"></i> Promociona anuncios ilimitados</li>
                                <li><i class="fas fa-check-circle feature-icon" style="color: rgb(250, 113, 255)"></i> Soporte premium 24/7</li>
                                <li><i class="fas fa-check-circle feature-icon" style="color: rgb(250, 113, 255)"></i> Acceso a ofertas exclusivas</li>
                                <li><i class="fas fa-check-circle feature-icon" style="color: rgb(250, 113, 255)"></i> Prioridad en las reservas</li>
                                <li><i class="fas fa-check-circle feature-icon" style="color: rgb(250, 113, 255)"></i> Acceso anticipado a nuevas funciones</li>
                            </ul>
                            <a href="../pago/iniciar_pago.php?tipo=premium" class="btn btn-premium btn-plan" style="background: linear-gradient(135deg, #C4EEF2 0%,rgb(250, 113, 255) 100%); margin-top:6vh">Suscribirse</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <?php include_once '../../components/footer-example.php'; ?>

    <script>
        function togglePlan(header) {
            const card = header.closest('.plan-card');
            // Solo activa el desplegable si el ancho es menor o igual a 700px
            if (window.innerWidth <= 767) {
                card.classList.toggle('open');
            }

        }
    </script>
</body>

</html>