<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
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

                    <p>En cumplimiento de la normativa vigente, informamos que este sitio web utiliza cookies técnicas necesarias para su funcionamiento. No se usan cookies analíticas, de personalización ni de terceros.</p>

                    <h2>¿Qué son las cookies?</h2>
                    <p>Archivos que se almacenan en el dispositivo del usuario para mejorar la experiencia de navegación. Algunas se eliminan al cerrar el navegador (cookies de sesión), otras permanecen (cookies permanentes).</p>

                    <h2>Tipos de cookies que usamos</h2>
                    <ul>
                        <li><strong>Cookies técnicas:</strong> esenciales para el uso del sitio web.</li>
                    </ul>

                    <h2>Configuración o eliminación de cookies</h2>
                    <p>Puedes desactivar las cookies desde tu navegador. Enlaces útiles:</p>
                    <ul>
                        <li><a href="https://support.google.com/chrome/answer/95647?hl=es">Chrome</a></li>
                        <li><a href="http://windows.microsoft.com/es-es/windows-vista/block-or-allow-cookies">Internet Explorer</a></li>
                        <li><a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-que-los-sitios-we">Firefox</a></li>
                        <li><a href="https://support.apple.com/es-es/guide/safari/sfri47acf5d6/mac">Safari</a></li>
                        <li><a href="https://support.google.com/chrome/answer/2392971?hl=es">Chrome para Android</a></li>
                    </ul>

                </main>
            </div>
        </div>
        <?php include_once '../../components/footer-example.php'; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>

    </html>

</html>
</body>

</html>