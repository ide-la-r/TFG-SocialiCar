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
                    <a href="../pages/informacion/aviso_legal.php" class="list-group-item list-group-item-action">Aviso legal</a>
                    <a href="../pages/informacion/politica_privacidad.php" class="list-group-item list-group-item-action">Política de privacidad</a>
                    <a href="../pages/informacion/cookies.php" class="list-group-item list-group-item-action">Cookies</a>
                    <a href="../pages/informacion/accesibilidad.php" class="list-group-item list-group-item-action">Accesibilidad</a>
                </div>
            </nav>
            <!-- Contenido principal centrado y comprimido -->
            <main class="col-12 col-md-8 col-lg-6 mx-auto py-4">
                <h2 class="mb-3">Política de Privacidad</h2>
                <p class="text-muted mb-4"><strong>Responsable:</strong> Socialicar (B93091536)<br>
                    <strong>Domicilio:</strong> C. Alejandro Dumas, 17, Carretera de Cádiz, 29004 Málaga<br>
                    <strong>Email:</strong> <a href="mailto:socialicar.rentacar@gmail.com">socialicar.rentacar@gmail.com</a>
                </p>

                <h4>Datos que recogemos</h4>
                <ul>
                    <li>Nombre y apellidos</li>
                    <li>DNI</li>
                    <li>Fecha de nacimiento</li>
                    <li>Email</li>
                    <li>Teléfono</li>
                </ul>

                <h4>Finalidad del tratamiento</h4>
                <p>Gestión de productos contratados, envío de obsequios en cumpleaños, y otras finalidades previamente informadas.</p>

                <h4>Base legal</h4>
                <p>Consentimiento, ejecución de contrato y cumplimiento de obligaciones legales.</p>

                <h4>Plazo de conservación</h4>
                <p>Los datos se conservarán durante 6 años.</p>

                <h4>Encargados del tratamiento</h4>
                <p>InfinityFree (<a href="https://www.infinityfree.com">www.infinityfree.com</a>)</p>

                <h4>Transferencias internacionales</h4>
                <p>No se realizan.</p>

                <h4>Derechos del usuario</h4>
                <p>Puedes ejercer tus derechos de acceso, rectificación, supresión, oposición, limitación y portabilidad:</p>
                <ul>
                    <li>Desde tu perfil en el apartado GDPR</li>
                    <li>Por correo a <a href="mailto:socialicar.rentacar@gmail.com">socialicar.rentacar@gmail.com</a> adjuntando tu DNI</li>
                </ul>
                <p>También puedes presentar una reclamación ante la AEPD:</p>
                <p>Dirección: C. Alejandro Dumas, 17, Carretera de Cádiz, 29004 Málaga<br>Teléfono: 951 56 46 58</p>
            </main>
        </div>
    </div>
    <?php include_once '../../components/footer-example.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

</html>