<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de usuario</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
</head>
<body>
<?php include_once '../../components/navbar.php'; ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow rounded-4 p-4">
                    <div class="row g-4 mb-4">
                        <!-- FOTO DE PERFIL -->
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <div class="bg-light rounded-4 shadow-sm p-4 w-100 text-center">
                                <img src="" alt="Imagen del usuario" class="rounded-circle mb-3" width="100" height="100">
                                <h6 class="mb-0">Foto Perfil</h6>
                            </div>
                        </div>
                        <!-- DATOS PERSONALES -->
                        <div class="col-md-8">
                            <div class="bg-light rounded-4 shadow-sm p-4 h-100">
    <div class="mb-3">
    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Datos personales</h5>
</div>
<ul class="list-unstyled mb-0">
    <li><strong>Nombre:</strong></li>
    <li><strong>Email:</strong></li>
    <li><strong>Teléfono:</strong></li>
    <!-- Añade más datos si lo deseas -->
</ul>
<div class="text-center mt-4">
    <a href="/socialicar/src/pages/usuario/editar_usuario.php" class="btn btn-outline-primary btn-sm">Cambiar credenciales</a>
</div>
</div>
                        </div>
                    </div>
                    <!-- TUS VEHICULOS -->
                    <div class="row">
                        <div class="col-12">
                            <div class="bg-light rounded-4 shadow-sm p-4">
                                <h5 class="mb-3"><i class="fas fa-car me-2"></i>Tus vehículos</h5>
                                <div class="text-center text-muted py-4">
                                    <!-- LISTA DE VEHICULOS -->
                                    <i class="fas fa-car-side fa-2x mb-2"></i>
                                    <p class="mb-0">Aún no has registrado vehículos.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once '../../components/footer.php';?>
</body>
</html>