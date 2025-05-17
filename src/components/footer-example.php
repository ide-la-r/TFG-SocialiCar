<div class="wave-container">
  <!-- Onda trasera más transparente -->
  <svg class="wave wave-back" viewBox="0 0 2400 120" preserveAspectRatio="none">
    <path d="M0,30 C300,90 600,-30 900,30 C1200,90 1500,-30 1800,30 C2100,90 2400,-30 2400,120 L0,120 Z"
      fill="#131719" fill-opacity="0.3" />
  </svg>

  <!-- Onda delantera más opaca -->
  <svg class="wave wave-front" viewBox="0 0 2400 120" preserveAspectRatio="none">
    <path d="M0,30 C300,90 600,-30 900,30 C1200,90 1500,-30 1800,30 C2100,90 2400,-30 2400,120 L0,120 Z"
      fill="#131719" fill-opacity="1" />
  </svg>
</div>

<style>
.wave-container {
  position: relative;
  height: 120px;
  overflow: hidden;
  margin-bottom: -1px;
}

.wave {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 200%;
  height: 100%;
  animation: waveMove 15s linear infinite;
}

.wave-back {
  z-index: 1;
  animation-duration: 25s;
}

.wave-front {
  z-index: 2;
}

@keyframes waveMove {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50%);
  }
}

.footer-02 {
  margin-top: -80px;  
  padding-top: 60px; 
}



</style>

<footer class="footer-02 mt-auto" style="background: #131719; position: relative; z-index: 2;">

<!-- ANTES DEL FOOTER - WAVE -->
<!-- Modifica el div de la onda -->
<div class="custom-wave" style="position: relative; height: 100px; margin-bottom: -1px;">
  <svg style="display: block; height: 100px; width: 100%" viewBox="0 0 1200 120" preserveAspectRatio="none">
    <path fill="#131719" d="M0,64L80,58.7C160,53,320,43,480,48C640,53,800,75,960,74.7C1120,75,1280,53,1360,42.7L1440,32L1440,320L1360,320C1280,320,1280,320,1120,320C960,320,800,320,640,320C480,320,320,320,160,320L80,320L0,320Z"></path>
  </svg>
</div>

<footer class="footer-02" style="background: #131719; position: relative">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-10 col-lg-6">
        <div class="subscribe mb-5 pb-5">
          <form action="#" class="subscribe-form">
            <div class="form-group d-flex">
              <input type="text" class="form-control rounded-left " placeholder="Enter email address">
              <input type="submit" value="Subscribe" class="form-control submit px-3">
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-lg-5">
        <div class="row">
          <div class="col-md-12 col-lg-8 mb-md-0 mb-4">
            <h2 class="footer-heading"><a href="#" class="logo">Socialicar</a></h2>
            <p>SocialiCar es un intermediario destinado al alquiler de vehículos entre particulares. La idea surge ante la creciente necesidad de alternativas de movilidad más flexibles, accesibles y sostenibles. </p>
            <a href="../pages/informacion/proposito.php">Mas informacion <span class="ion-ios-arrow-round-forward"></span></a>
          </div>
        </div>
      </div>
      <div class="col-md-8 col-lg-7">
        <div class="row">
          <div class="col-md-3 mb-md-0 mb-4 border-left">
            <h2 class="footer-heading">Informacion</h2>
            <ul class="list-unstyled">
              <li><a href="/src/pages/informacion/proposito.php" class="py-1 d-block">Sobre nosotros</a></li>
              <li><a href="/src/pages/informacion/contacto.php" class="py-1 d-block">Contacto</a></li>
              <li><a href="/src/pages/informacion/trabaja.php" class="py-1 d-block">Trabaja con nosotros</a></li>
              <li><a href="/src/pages/informacion/soporte.php" class="py-1 d-block">Atencion al cliente</a></li>
            </ul>
          </div>
          <div class="col-md-3 mb-md-0 mb-4 border-left">
            <h2 class="footer-heading">Alquiler de coches</h2>
            <ul class="list-unstyled">
              <li><a href="/src/pages/coche/nuevo_coche.php" class="py-1 d-block">Alquila tu coche</a></li>
              <li><a href="/src/pages/rentacar/mostrar_coches.php" class="py-1 d-block">Encontrar un coche</a></li>
              <li><a href="/src/pages/usuario/planes.php" class="py-1 d-block">Planes</a></li>
              <li><a href="/src/pages/informacion/ayuda.php" class="py-1 d-block">Guia</a></li>
            </ul>
          </div>
          <div class="col-md-3 mb-md-0 mb-4 border-left">
            <h2 class="footer-heading">Legal</h2>
            <ul class="list-unstyled">
              <li><a href="/src/pages/informacion/aviso_legal.php" class="py-1 d-block">Aviso legal</a></li>
              <li><a href="/src/pages/informacion/politica_privacidad.php" class="py-1 d-block">Politica de privacidad</a></li>
              <li><a href="/src/pages/informacion/politica_cookies.php" class="py-1 d-block">Cookies</a></li>
              <li><a href="/src/pages/informacion/accesibilidad.php" class="py-1 d-block">Accesibilidad</a></li>
            </ul>
          </div>
          <div class="col-md-3 mb-md-0 mb-4 border-left">
            <h2 class="footer-heading">Redes sociales</h2>
            <ul class="list-unstyled">
              <li><a href="https://www.facebook.com/people/SocialiCar-Rentacar/pfbid0eL6UbpgSWBv5jxYF5SV32DuJF645MRwvcVb1KXnVPvWNbfs8NYWQeHpUntVefi23l/" class="py-1 d-block">Facebook</a></li>
              <li><a href="https://x.com/socialicar_" class="py-1 d-block">Twitter</a></li>
              <li><a href="https://www.instagram.com/socialicar/" class="py-1 d-block">Instagram</a></li>
              <li><a href="https://www.tiktok.com/@socialicar" class="py-1 d-block">TikTok</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row partner-wrap mt-5">
      <div class="col-md-12">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="mb-0">Nuestro Equipo</h3>
          </div>
          <div class="col-md-9">
            <p class="partner-name mb-0">
              <a href="#"><span class="ion-logo-ionic mr-2"></span>Pablo Monis Alvarez</a>
              <a href="#"><span class="ion-logo-ionic mr-2"></span>Francisco Cortes Pirson</a>
              <a href="#"><span class="ion-logo-ionic mr-2"></span>Raul Martin Gonzalez</a>
              <a href="#"><span class="ion-logo-ionic mr-2"></span>Ismael de la rosa guerrero</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<script src="/src/js/jquery.min.js"></script>
<script src="/src/js/popper.js"></script>
<script src="/src/js/bootstrap.min.js"></script>
<script src="/src/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>