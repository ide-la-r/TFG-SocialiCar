<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <?php 
    include_once '../../components/links.php'; 
    require(__DIR__ . "/../../config/conexion.php");
    ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        session_start();
    ?>
    <link rel="stylesheet" href="../../styles/nuevo_coche_custom.css">
</head>
<body>
<?php include_once '../../components/navbar.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          <h2 class="mb-4 text-center">Contáctanos</h2>
          <p class="text-muted text-center mb-4">
            Estamos aquí para ayudarte en todo momento. Si tienes cualquier duda, no dudes en escribirnos.
          </p>
          <form autocomplete="off">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" placeholder="Tu nombre" required>
            </div>
            <div class="mb-3">
              <label for="correo" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="correo" placeholder="nombre@ejemplo.com" required>
            </div>
            <div class="mb-3">
              <label for="asunto" class="form-label">Asunto</label>
              <input type="text" class="form-control" id="asunto" placeholder="Motivo del mensaje" required>
            </div>
            <div class="mb-3">
              <label for="mensaje" class="form-label">Mensaje</label>
              <textarea class="form-control" id="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary btn-lg">Enviar mensaje</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once '../../components/footer-example.php';?>
</body>
</html>