<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre nosotros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="../../../src/styles/sobre_nosotros.css">
</head>
<body>
<?php include_once '../../components/navbar.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Alquila o renta tu coche con confianza</h1>
        <p class="lead mb-0">Plataforma de alquiler entre particulares</p>
    </div>
</section>

<!-- About Section -->
<div class="container py-5">
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
            <h2 class="section-title display-5 mb-4">Sobre este proyecto</h2>
            <p class="lead">SocialiCar es una plataforma desarrollada como Trabajo de Fin de Grado que busca conectar propietarios de vehículos con personas que necesitan alquilar un coche.</p>
        </div>
    </div>

    <!-- Mission Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3 text-primary">
                        <i class="fas fa-car fa-3x"></i>
                    </div>
                    <h3 class="card-title h4">Objetivo</h3>
                    <p class="card-text">Demostrar la viabilidad técnica de una plataforma de alquiler entre particulares, priorizando seguridad y usabilidad.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3 text-primary">
                        <i class="fas fa-eye fa-3x"></i>
                    </div>
                    <h3 class="card-title h4">Visión</h3>
                    <p class="card-text">Ser una plataforma líder en movilidad colaborativa, reconocida por su impacto positivo en el medio ambiente y en la vida de las personas.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3 text-primary">
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                    <h3 class="card-title h4">Valores</h3>
                    <ul class="list-unstyled">
                        <li> Colaboración</li>
                        <li> Sostenibilidad</li>
                        <li> Innovación</li>
                        <li> Confianza</li>
                        <li> Responsabilidad social</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="section-title display-5 mb-4">Nuestro Equipo</h2>
                    <p class="lead">4 apasionados por la movilidad compartida</p>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-md-6 text-center">
                    <img src="../../img/yo.png" alt="Team Member" class="team-img mb-3">
                    <h4>Raul Martin</h4>
                    <p class="text-muted">CEO</p>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <img src="../../img/isma.png" alt="Team Member" class="team-img mb-3">
                    <h4>Ismael me la roza</h4>
                    <p class="text-muted">CEO</p>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <img src="../../img/Pablo.png" alt="Team Member" class="team-img mb-3">
                    <h4>Pablo monis</h4>
                    <p class="text-muted">CEO</p>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <img src="../../img/fran.png" alt="Team Member" class="team-img mb-3">
                    <h4>Francisco cortes</h4>
                    <p class="text-muted">CEO</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="section-title display-5 mb-4">Experiencias de nuestros usuarios</h2>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card testimonial-card h-100 p-4">
                        <p class="fst-italic">"Alquilar mi coche a través de SocialiCar ha sido muy sencillo y me genera ingresos extras cada mes."</p>
                        <div class="d-flex align-items-center mt-3">
                            <img src="../../img/dani.jpg" alt="User" width="50" height="50" class="rounded-circle me-3">
                            <div>
                                <h6 class="mb-0">Daniel Canillas</h6>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card testimonial-card h-100 p-4">
                        <p class="fst-italic">"Me encanta la comunidad de SocialiCar. Todos son muy amigables y dispuestos a ayudar."</p>
                        <div class="d-flex align-items-center mt-3">
                            <img src="../../img/jaime.jpg" alt="User" width="50" height="50" class="rounded-circle me-3">
                            <div>
                                <h6 class="mb-0">Jaime esteban</h6>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card testimonial-card h-100 p-4">
                        <p class="fst-italic">"SocialiCar es la mejor opción para aquellos que buscan una forma de transporte sostenible y accesible."</p>
                        <div class="d-flex align-items-center mt-3">
                            <img src="../../img/victor.jpg" alt="User" width="50" height="50" class="rounded-circle me-3">
                            <div>
                                <h6 class="mb-0">Victor cantero</h6>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include_once '../../components/footer-example.php'; ?>

<!-- Scripts -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>