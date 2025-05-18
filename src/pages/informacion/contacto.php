<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include_once '../../components/links.php'; ?>
  <link rel="icon" href="../../../src/img/favicon.png" />
  <link rel="stylesheet" href="../../styles/.css">
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
      font-size: 0.875rem;
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
      border: 1px solid black;
      border-radius: 20px;
    }

    .contact-info .icon-circle i {
      color: #6BBFBF;
    }

  </style>
</head>

<body>
  <?php include_once '../../components/navbar.php'; ?>

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
              <p class="text-center text-muted mb-4">¿Tienes alguna consulta o necesitas información? Completa el formulario y te responderemos lo antes posible.</p>

              
<div class="centrar-pantalla">
  <form>
    <div class="row mb-3">
      <div class="col">
        <div class="form-floating">
          <input type="text" class="form-control" id="nombre" placeholder="Nombre">
          <label for="nombre">Nombre</label>
        </div>
      </div>
      <div class="col">
        <div class="form-floating">
          <input type="tel" class="form-control" id="telefono" placeholder="Teléfono">
          <label for="telefono">Teléfono</label>
        </div>
      </div>
    </div>
    <div class="mb-3">
      <div class="form-floating">
        <input type="email" class="form-control" id="email" placeholder="Email">
        <label for="email">Email</label>
      </div>
    </div>
    <div class="mb-3">
      <div class="form-floating">
        <input type="text" class="form-control" id="asunto" placeholder="Asunto">
        <label for="asunto">Asunto</label>
      </div>
    </div>
    <div class="mb-4">
      <div class="form-floating">
        <textarea class="form-control" placeholder="Mensaje" id="mensaje" style="height: 120px"></textarea>
        <label for="mensaje">Mensaje</label>
      </div>
    </div>
    <button type="submit" class="btn w-50" style="background-color: #6BBFBF; display: block; margin: 0 auto;">Enviar</button>
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