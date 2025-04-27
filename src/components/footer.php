<!-- Footer estilo minimalista y alineado como en el ejemplo proporcionado -->
<footer class="bg-light mt-auto" style="background-color: #F2F2F2!important; color: #595959; font-size: 0.95rem;">
  <div class="container pt-5 pb-2">
    <div class="row mb-2">
      <!-- Información del tfg sacado del plan de empresa -->
      <div class="col-md-4 mb-4 mb-md-0">
        <h6 class="fw-semibold mb-1" style="color: #6BBFBF;">SocialiCar</h6>
        <p class="mb-0" style="color: #595959; font-size: 0.93em; width: 70%">
          SocialiCar es un intermediario destinado al alquiler de vehículos entre particulares. La idea surge ante la creciente necesidad de alternativas de movilidad más flexibles, accesibles y sostenibles. 
        </p>
      </div>
      <!-- Enlaces del footer -->
      <div class="col-md-4 mb-4 mb-md-0">
        <h6 class="fw-semibold mb-1" style="color: #6BBFBF;">Información</h6> <!-- NOMBRE PROVISIONAL  -->
        <ul class="list-unstyled mb-0">
          <li><a href="/socialicar/index.php" class="text-decoration-none" style="color: #595959;">Inicio</a></li>
          <li><a href="/socialicar/src/pages/informacion/trabaja.php" class="text-decoration-none" style="color: #595959;">Trabaja con nosotros</a></li>
          <li><a href="/socialicar/src/pages/rentacar/mostrar_coches.php" class="text-decoration-none" style="color: #595959;">Encontrar un coche</a></li>
          <li><a href="/socialicar/src/pages/informacion/descarga_app.php" class="text-decoration-none" style="color: #595959;">Descarga nuestra app</a></li>
          <li><a href="/socialicar/src/pages/informacion/proposito.php" class="text-decoration-none" style="color: #595959;">Propósito</a></li>
        </ul>
      </div>
      <!-- Contacto -->
      <div class="col-md-4">
        <h6 class="fw-semibold mb-1" style="color: #6BBFBF;">Contacto</h6>
        <div class="mb-1">
          <i class="fas fa-envelope me-2" style="color: #6BBFBF;"></i>
          <span style="color: #595959;">socialicar.rentacar@gmail.com</span>
        </div>
        <div class="mb-1">
          <i class="fas fa-phone me-2" style="color: #6BBFBF;"></i>
          <span style="color: #595959;">951 56 46 58</span>
        </div>
        <div>
          <i class="fas fa-map-marker-alt me-2" style="color: #6BBFBF;"></i>
          <span style="color: #595959;">C. Alejandro Dumas, 17, Málaga</span>
        </div>
      </div>
    </div>
    <hr class="mb-2 mt-0" style="border-color: #B0D5D9;" />
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pb-2">
      <div class="mb-2 mb-md-0">
        <!-- Redes sociales alineadas a la izquierda -->
        <a href="https://www.facebook.com/people/SocialiCar-Rentacar/pfbid0eL6UbpgSWBv5jxYF5SV32DuJF645MRwvcVb1KXnVPvWNbfs8NYWQeHpUntVefi23l/" class="me-3" style="color: #6BBFBF;" target="_blank" rel="noopener"><i class="fab fa-facebook fa-lg"></i></a>
        <a href="https://www.instagram.com/socialicar/" class="me-3" style="color: #6BBFBF;" target="_blank" rel="noopener"><i class="fab fa-instagram fa-lg"></i></a>
        <a href="https://x.com/socialicar_" class="me-3" style="color: #6BBFBF;" target="_blank" rel="noopener"><i class="fab fa-twitter fa-lg"></i></a>
        <a href="https://www.linkedin.com" class="me-3" style="color: #6BBFBF;" target="_blank" rel="noopener"><i class="fab fa-linkedin fa-lg"></i></a>
      </div>
      <div class="text-end w-100 w-md-auto" style="color: #595959; font-size: 0.88em;">
        &copy; <?php echo date('Y'); ?> SocialiCar. Todos los derechos reservados.
      </div>
    </div>
  </div>
</footer>
<!-- FontAwesome CDN para iconos sociales -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="/socialicar/src/js/mostrar_marcas.js"></script>
<script src="/socialicar/src/js/precio_coche.js"></script>