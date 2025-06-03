<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include_once '../../components/links.php'; ?>
  <link rel="icon" href="../../../src/img/favicon.png" />
  <link rel="stylesheet" href="../../styles/contacto.css">
  <title>Contacto</title>
  <style>
    .contact-section {
      min-height: 100vh;
      display: flex;
      align-items: center;
    }

    .contact-card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);

    }

    .contact-image {
      object-fit: cover;
      border-top-left-radius: 1rem;
      border-bottom-left-radius: 1rem;
    }

    .icon-circle {
      width: 48px;
      height: 48px;
      background-color: #C4EEF2;
    }

    .contact-info a {
      color: inherit;
    }

    @media (max-width: 991.98px) {
      .contact-image {
        border-radius: 1rem 1rem 0 0;
        height: 300px;
      }
    }

    .error {
      color: red;
    }

    body {
      background:
        url('../../img/nuevo_fondo.JPG');
      background-size: cover;
      background-position: center;
      margin: 0;
    }

    .card {
      background: #F8F9FD;
      padding: 25px 35px;
      background-color: rgb(255, 255, 255);
      border-radius: 30px;
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.9);
      margin: 1rem auto;
      width: 1800px;

    }

    h1 {
      color: #222831;
      font-weight: 700;
      font-size: 2.4rem;
      margin-bottom: 2rem;
      padding-left: 1rem;
      text-align: center;
    }


    /* PONER EN LOS DEMAS ARCHIVOS */
    .form-floating>.form-control,
    .form-floating>.form-select {
      border-radius: 20px;
    }

    .contact-info .icon-circle i {
      color: #6BBFBF;
    }
    .btn-send{
      background-color: #6BBFBF;
      color: white;
      border-color: #6BBFBF;
      display: block; 
      margin: 0 auto;
    }
    .btn-send:hover {
      background-color: #5a9b9b;
      border-color: #5a9b9b;
      color: #e0e0e0;
    }
  </style>


  <?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  require(__DIR__ . "/../../config/conexion.php");
  require(__DIR__ . "/../../config/depurar.php");

  session_start();
  ?>
</head>

<body>
  <!-- NAVBAR -->
  <?php include_once '../../components/navbar.php'; ?>

  <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $tmp_nombre = depurar($_POST['nombre']);
      $tmp_telefono = $_POST['telefono'];
      $tmp_email = depurar($_POST['email']);
      $tmp_asunto = depurar($_POST['asunto']);
      $tmp_mensaje = depurar($_POST['mensaje']);

      /* Validar nombre */
      if (empty($tmp_nombre)) {
        $err_nombre = "El nombre es obligatorio.";
      } else {
        $patron_nombre = "/^[a-zA-ZÀ-ÿ\s\-]+$/u";
        if (!preg_match($patron_nombre, $tmp_nombre)) {
          $err_nombre = "El nombre solo puede contener letras y espacios.";
        } else{
          $nombre = $tmp_nombre;
        }
      }

      /* Validar teléfono */
      if (empty($tmp_telefono)) {
        $err_telefono = "El teléfono es obligatorio.";
      } else {
        $patron_telefono = "/^(\+34)?\s?\d{3}\s?\d{3}\s?\d{3}$/";
        if (!preg_match($patron_telefono, $tmp_telefono)) {
          $err_telefono = "El teléfono debe tener 9 dígitos.";
        } else {
          $telefono = $tmp_telefono;
        }
      }

      /* Validar email */
      if (empty($tmp_email)) {
        $err_email = "El email es obligatorio.";
      } else {
        if (!filter_var($tmp_email, FILTER_VALIDATE_EMAIL)) {
          $err_email = "El email no es válido.";
        } else {
          $email = $tmp_email;
        }
      }

      /* Validar asunto */
      if (empty($tmp_asunto)) {
        $err_asunto = "El asunto es obligatorio.";
      } else {
        $asunto = $tmp_asunto;
      }

      /* Validar mensaje */
      if (empty($tmp_mensaje)) {
        $err_mensaje = "El mensaje es obligatorio.";
      } else {
        $mensaje = $tmp_mensaje;
      }

      // Si no hay errores, enviar el correo
      if (isset($nombre, $telefono, $email, $asunto, $mensaje)) {
        echo "<script>
                window.location.href = '/src/pages/correo/formulario_correo.php?correo=" . urlencode($email) . "&mensaje=" . urlencode($mensaje) . "&asunto=" . urlencode($asunto) . "&nombre=" . urlencode($nombre) . "&telefono=" . urlencode($telefono) . "';
              </script>";
      }
    }

  ?>


  <section class="contact-section py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="card contact-card overflow-hidden p-0 col-lg-10">
          <div class="row g-0">
            <!-- Imagen -->
            <div class="col-lg-6 p-4">
              <img src="../../img/imagen_contacto.jpg" alt="Imagen de contacto" class="img-fluid w-100 h-100 contact-image" />
            </div>


            <!-- Formulario -->
            <div class="col-lg-6 d-flex flex-column justify-content-center p-5">
              <h1 class="mb-3 text-center fw-bold">Contacto</h1>
              <p class="text-center text-muted mb-4">¿Tienes alguna consulta o necesitas información? <br> Completa el formulario y te responderemos lo antes posible.</p>


              <div class="centrar-pantalla">
                <form action="#" id="formulario" method="post" enctype="multipart/form-data">

                  <div class="row mb-3">

                    <div class="col">
                      <div class="form-floating">
                        <input class="form-control <?php if (isset($err_nombre)) echo 'is-invalid'; ?>" id="floatingInput" type="text" placeholder="Nombre*" name="nombre" value="<?php if (isset($nombre)) echo htmlspecialchars($nombre); ?>">
                        <label for="floatingInput">Nombre</label>
                        <?php
                          if (isset($err_nombre)) {
                              echo "<span class='error'>$err_nombre</span>";
                          }
                        ?>
                      </div>
                    </div>

                    <div class="col">
                      <div class="form-floating">
                        <input class="form-control <?php if (isset($err_telefono)) echo 'is-invalid'; ?>" id="floatingInput" type="text" placeholder="Teléfono*" name="telefono" value="<?php if (isset($telefono)) echo htmlspecialchars($telefono); ?>">
                        <label for="floatingInput">Teléfono</label>
                        <?php
                          if (isset($err_telefono)) {
                              echo "<span class='error'>$err_telefono</span>";
                          }
                        ?>
                      </div>
                    </div>

                  </div>

                  <div class="mb-3">
                    <div class="form-floating">
                      <input class="form-control <?php if (isset($err_email)) echo 'is-invalid'; ?>" id="floatingInput" type="text" placeholder="Correo electrónico*" name="email" value="<?php if (isset($email)) echo htmlspecialchars($email); ?>">
                      <label for="floatingInput">Correo electrónico</label>
                      <?php
                        if (isset($err_email)) {
                            echo "<span class='error'>$err_email</span>";
                        }
                      ?>
                    </div>
                  </div>

                  <div class="mb-3">
                    <div class="form-floating">
                      <input class="form-control <?php if (isset($err_asunto)) echo 'is-invalid'; ?>" id="floatingInput" type="text" placeholder="Asunto*" name="asunto" value="<?php if (isset($asunto)) echo htmlspecialchars($asunto); ?>">
                      <label for="floatingInput">Asunto</label>
                      <?php
                        if (isset($err_asunto)) {
                            echo "<span class='error'>$err_asunto</span>";
                        }
                      ?>
                    </div>
                  </div>

                  <div class="mb-4">
                    <div class="form-floating">
                      <textarea class="form-control <?php if (isset($err_mensaje)) echo 'is-invalid'; ?>" name="mensaje" id="floatingTextarea2" rows="3" style="height: 100px" placeholder="Mensaje*"><?php if (isset($mensaje)) echo "$mensaje"; ?></textarea>
                      <label for="floatingTextarea2">Mensaje</label>
                      <?php
                      if (isset($err_mensaje)) {
                          echo "<span class='error'>$err_mensaje</span>";
                      }
                      ?>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-send w-50">Enviar</button>

                </form>
              </div>

              <!-- Información de contacto -->
              <div class="contact-info mt-5">
                <div class="d-flex align-items-center mb-3">
                  <div class="icon-circle d-flex justify-content-center align-items-center rounded-circle me-3">
                    <i class="bi bi-geo-alt-fill fs-5"></i>
                  </div>
                  <div>
                    <div class="fw-bold">Estamos en</div>
                    <div>C. Alejandro Dumas, 17, Carretera de Cádiz, 29004 Málaga</div>
                  </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                  <div class="icon-circle d-flex justify-content-center align-items-center rounded-circle me-3">
                    <i class="bi bi-envelope-fill fs-5"></i>
                  </div>
                  <div>
                    <div class="fw-bold">Email</div>
                    <a href="mailto:socialicar.rentacar@gmail.com" class="text-decoration-none">socialicar.rentacar@gmail.com</a>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <div class="icon-circle d-flex justify-content-center align-items-center rounded-circle me-3">
                    <i class="bi bi-telephone-fill fs-5"></i>
                  </div>
                  <div>
                    <div class="fw-bold">Teléfono</div>
                    <a href="tel:+34635345567" class="text-decoration-none">635 345 567</a>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div> <!-- card -->
      </div>
    </div>
  </section>

  <?php include_once '../../components/footer-example.php'; ?>
</body>

</html>