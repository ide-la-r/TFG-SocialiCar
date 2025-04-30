<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SocialiCar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />

  <style>
    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }

    main {
      flex: 1;
    }

    .footer-social-icons a {
      display: inline-block;
      margin-right: 1rem;
      font-size: 1.35em;
      color: #6BBFBF;
    }
    .footer-social-icons a:last-child {
      margin-right: 0;
    }
    .footer-social-icons i {
      vertical-align: middle;
    }
  </style>
</head>

<body>
  <!-- Contenido principal -->
  <main>
    <!-- Aquí va tu contenido de la página -->
  </main>

  <!-- Footer estilo minimalista y alineado -->
  <footer class="bg-light mt-auto" style="background-color: #F2F2F2!important; color: #595959; font-size: 1.08rem; padding-top: 2.5rem; padding-bottom: 1.5rem; border-top: 1px solid #B0D5D9;">
    <div class="container">
      <div class="row mb-3 gy-4 align-items-start">
        <div class="col-md-4 mb-4 mb-md-0">
          <h6 class="fw-semibold mb-2" style="color: #6BBFBF; font-size: 1.15em;">SocialiCar</h6>
          <p class="mb-0" style="color: #595959; font-size: 1em; max-width: 90%">
            SocialiCar es un intermediario destinado al alquiler de vehículos entre particulares. La idea surge ante la creciente necesidad de alternativas de movilidad más flexibles, accesibles y sostenibles. 
          </p>
        </div>

        <div class="col-md-4 mb-4 mb-md-0">
          <h6 class="fw-semibold mb-2" style="color: #6BBFBF; font-size: 1.15em;">Información</h6>
          <ul class="list-unstyled mb-0" style="font-size: 1em;">
            <li class="mb-1"><a href="/" class="text-decoration-none" style="color: #595959;">Inicio</a></li>
            <li class="mb-1"><a href="/src/pages/informacion/trabaja" class="text-decoration-none" style="color: #595959;">Trabaja con nosotros</a></li>
            <li class="mb-1"><a href="/src/pages/rentacar/mostrar_coches" class="text-decoration-none" style="color: #595959;">Encontrar un coche</a></li>
            <li class="mb-1"><a href="/src/pages/informacion/descarga_app" class="text-decoration-none" style="color: #595959;">Descarga nuestra app</a></li>
            <li><a href="/src/pages/informacion/proposito" class="text-decoration-none" style="color: #595959;">Propósito</a></li>
          </ul>
        </div>

        <div class="col-md-4">
          <h6 class="fw-semibold mb-2" style="color: #6BBFBF; font-size: 1.15em;">Contacto</h6>
          <div class="mb-2">
            <i class="fas fa-envelope me-2" style="color: #6BBFBF;"></i>
            <span style="color: #595959;">socialicar.rentacar@gmail.com</span>
          </div>
          <div class="mb-2">
            <i class="fas fa-phone me-2" style="color: #6BBFBF;"></i>
            <span style="color: #595959;">951 56 46 58</span>
          </div>
          <div>
            <i class="fas fa-map-marker-alt me-2" style="color: #6BBFBF;"></i>
            <span style="color: #595959;">C. Alejandro Dumas, 17, Málaga</span>
          </div>
        </div>
      </div>

      <hr class="mb-3 mt-0" style="border-color: #B0D5D9;" />
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pb-2 gap-2">
        <div class="mb-2 mb-md-0 d-flex align-items-center footer-social-icons">
          <a href="https://www.facebook.com/people/SocialiCar-Rentacar/pfbid0eL6UbpgSWBv5jxYF5SV32DuJF645MRwvcVb1KXnVPvWNbfs8NYWQeHpUntVefi23l/" class="me-3" target="_blank" rel="noopener"><i class="fab fa-facebook"></i></a>
          <a href="https://www.instagram.com/socialicar/" class="me-3" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
          <a href="https://x.com/socialicar_" class="me-3" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
        </div>
        <div class="text-end w-100 w-md-auto" style="color: #595959; font-size: 1em;">
          &copy; <?php echo date('Y'); ?> SocialiCar. Todos los derechos reservados.
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
  <script src="/src/js/mostrar_marcas.js"></script>
  <script src="/src/js/precio_coche.js"></script>
</body>
</html>
