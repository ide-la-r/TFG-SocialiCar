<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidad | Socialicar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <style>
        body {
            background: #fafbfc;
        }

        .sidebar-menu {
            min-height: 100vh;
        }

        .list-group-item.active {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }

        @media (max-width: 767.98px) {
            .sidebar-menu {
                min-height: auto;
            }
        }
    </style>
</head>

<body>
    <?php include_once '../../components/navbar.php'; ?>
    <div class="container">
        <div class="row">
            <!-- Menú lateral muy estrecho -->
            <nav class="col-12 col-md-2 col-lg-2 py-4 sidebar-menu">
                <div class="list-group sticky-top">
                    <a href="/src/pages/informacion/aviso_legal.php" class="list-group-item list-group-item-action">Aviso legal</a>
                    <a href="/src/pages/informacion/politica_privacidad.php" class="list-group-item list-group-item-action">Política de privacidad</a>
                    <a href="/src/pages/informacion/politica_cookies.php" class="list-group-item list-group-item-action">Cookies</a>
                    <a href="/src/pages/informacion/accesibilidad.php" class="list-group-item list-group-item-action">Accesibilidad</a>
                </div>
            </nav>
            <!-- Contenido principal centrado y comprimido -->
            <main class="col-12 col-md-8 col-lg-6 mx-auto py-4">
                <h1>Declaración de Accesibilidad</h1>

                <p>Socialicar se compromete a hacer accesible su sitio web <a href="https://socialicar.wuaze.com">socialicar.wuaze.com</a>, de conformidad con el nivel A de las Pautas de Accesibilidad para el Contenido Web (WCAG 2.1) del W3C.</p>

                <h2>Medidas para garantizar la accesibilidad</h2>
                <ul>
                    <li>Navegación por teclado para personas con movilidad reducida.</li>
                    <li>Contraste adecuado de colores para mejorar la legibilidad.</li>
                    <li>Textos alternativos en imágenes y elementos multimedia.</li>
                    <li>Estructura semántica coherente para facilitar la comprensión.</li>
                </ul>

                <h2>Situción de conformidad</h2>
                <p>Este sitio web es parcialmente conforme con el nivel A de las WCAG 2.1 debido a algunas excepciones que se están subsanando progresivamente.</p>

                <h2>Preparación de esta declaración</h2>
                <p>Esta declaración fue preparada el <strong>13 de mayo de 2025</strong>, mediante una autoevaluación interna realizada por el equipo de Socialicar.</p>

                <h2>Observaciones y datos de contacto</h2>
                <p>Si detectas problemas de accesibilidad en esta web, por favor escríbenos a <a href="mailto:socialicar.rentacar@gmail.com">socialicar.rentacar@gmail.com</a> indicando el asunto “Accesibilidad”. Estudiaremos tu caso y te daremos respuesta en el menor plazo posible.</p>

            </main>
        </div>
    </div>
    <?php include_once '../../components/footer-example.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

</html>