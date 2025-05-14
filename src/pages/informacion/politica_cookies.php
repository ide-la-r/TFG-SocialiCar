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
                <h1>Política de Cookies</h1>

                <p>Este sitio utiliza solo cookies técnicas necesarias para su funcionamiento. No se utilizan cookies de terceros ni herramientas de análisis.</p>

                <h2>¿Qué son las cookies?</h2>
                <p>Archivos que permiten almacenar y recuperar información del usuario para mejorar la experiencia de navegación.</p>

                <h2>Tipo de cookies utilizadas</h2>
                <ul>
                    <li><strong>Cookies técnicas:</strong> esenciales para la navegación y el acceso a funciones básicas.</li>
                </ul>

                <h2>Configuración de cookies</h2>
                <p>Si deseas deshabilitar las cookies, puedes hacerlo desde tu navegador:</p>
                <ul>
                    <li><a href="https://support.google.com/chrome/answer/95647?hl=es">Chrome</a></li>
                    <li><a href="http://windows.microsoft.com/es-es/windows-vista/block-or-allow-cookies">Internet Explorer</a></li>
                    <li><a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-que-los-sitios-we">Firefox</a></li>
                    <li><a href="https://support.apple.com/es-es/guide/safari/sfri47acf5d6/mac">Safari</a></li>
                    <li><a href="http://support.apple.com/kb/ht1677?viewlocale=es_es">iOS Safari</a></li>
                    <li><a href="https://support.google.com/chrome/answer/2392971?hl=es">Chrome Android</a></li>
                </ul>
            </main>
        </div>
    </div>
    <?php include_once '../../components/footer-example.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

</html>