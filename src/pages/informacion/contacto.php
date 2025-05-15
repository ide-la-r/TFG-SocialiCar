<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include_once '../../components/links.php'; ?>
  <link rel="icon" href="../../../src/img/favicon.png" />
  <link rel="stylesheet" href="../../styles/nuevo_coche_custom.css">
  <title>Contacto</title>
</head>
<body>
  <?php include_once '../../components/navbar.php'; ?>

  <div class="container-fluid py-5">
    <div class="row align-items-stretch justify-content-center">
      <!-- Imagen a la izquierda -->
      <div class="col-lg-6 mb-4 mb-lg-0 d-flex align-items-stretch">
        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb" alt="Farmacia" class="img-fluid rounded shadow w-100" style="object-fit:cover; min-height:400px;">
      </div>
      <!-- Formulario a la derecha -->
      <div class="col-lg-6 d-flex flex-column justify-content-center h-100">
        <div class="d-flex flex-column justify-content-center h-100 w-100">
          <h1 class="mb-2 text-center display-3">Contacto</h1>
          <p class="mb-4 text-muted text-center">¿Tienes alguna consulta o necesitas información? Completa el formulario y te responderemos lo antes posible.</p>
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
              <textarea class="form-control" id="mensaje" rows="4" placeholder="Mensaje"></textarea>
              <label for="mensaje">Mensaje</label>
            </div>
          </div>
          <button type="submit" class="btn btn-success w-100">Enviar</button>
        </form>
        <!-- Bloque de contacto visual debajo del formulario -->
        <div class="mt-5">
          <div class="d-flex align-items-center mb-4">
            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light me-3" style="width:48px; height:48px;">
              <i class="bi bi-geo-alt-fill text-success fs-4"></i>
            </span>
            <div>
              <div class="fw-bold">Estamos en</div>
              <div>C. Alejandro Dumas, 17, Carretera de Cádiz, 29004 Málaga</div>
            </div>
          </div>
          <div class="d-flex align-items-center mb-4">
            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light me-3" style="width:48px; height:48px;">
              <i class="bi bi-envelope-fill text-success fs-4"></i>
            </span>
            <div>
              <div class="fw-bold">Email</div>
              <div><a href="mailto:socialicar.rentacar@gmail.com" class="text-decoration-none">socialicar.rentacar@gmail.com</a></div>
            </div>
          </div>
          <div class="d-flex align-items-center mb-4">
            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light me-3" style="width:48px; height:48px;">
              <i class="bi bi-telephone-fill text-success fs-4"></i>
            </span>
            <div>
              <div class="fw-bold">Teléfono</div>
              <div><a href="tel:+34635345567" class="text-decoration-none">635 345 567</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include_once '../../components/footer-example.php'; ?>
</body>

</html>