<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<div class="wave-container">
  <svg class="wave wave-front" style="display: block; height: 120px; width: 200%; z-index: 2; left: 0;" viewBox="0 0 1200 150" preserveAspectRatio="none">
    <path fill="#131719" d="M0,80 C200,140 400,60 600,110 C800,60 1000,140 1200,80 L1200,200 L0,200 Z"></path>
    <path fill="#131719" d="M1200,80 C1400,140 1600,60 1800,110 C2000,60 2200,140 2400,80 L2400,200 L1200,200 Z"></path>
  </svg>
  <svg class="wave wave-back" style="display: block; height: 150px; width: 200%; z-index: 1; opacity: 0.4; transform: translateY(-30px) translateX(-25%);" viewBox="0 0 1200 150" preserveAspectRatio="none">
    <path fill="#131719" d="M0,80 C100,130 200,70 300,120 C400,70 500,130 600,100 C700,130 800,70 900,120 C1000,70 1100,130 1200,80 L1200,200 L0,200 Z"></path>
    <path fill="#131719" d="M1200,80 C1300,130 1400,70 1500,120 C1600,70 1700,130 1800,100 C1900,130 2000,70 2100,120 C2200,70 2300,130 2400,80 L2400,200 L1200,200 Z"></path>
  </svg>
</div>

<style>
.wave-container {
  position: relative;
  height: 150px;
  overflow: hidden;
  margin-bottom: -1px;
  width: 100%;

}

.wave {
  display: block;
  width: 200%;
  height: auto;
  position: absolute;
  bottom: 0;
  left: 0;
}

.wave-front {
  animation: waveMoveFront 15s linear infinite; /* He vuelto a 'linear' para un movimiento constante con las nuevas curvas */
}

.wave-back {
  animation: waveMoveBack 20s cubic-bezier(0.33, 0.66, 0.66, 1) infinite;
  opacity: 0.4;
  transform: translateY(-30px) translateX(-25%);
  height: 150px;
}

@keyframes waveMoveFront {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50%);
  }
}

@keyframes waveMoveBack {
  0% {
    transform: translateX(-50%);
  }
  100% {
    transform: translateX(0);
  }
}

.footer-02 {
  margin-top: -80px;
  padding-top: 60px;
  background: #131719;
  position: relative;
  z-index: 3;
}

.social-icons {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
  padding-left: 0;
  margin-top: -8px;
}

.social-icons li {
  margin: 0;
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.social-icons a {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  height: 24px;
  font-size: 0.95rem;
  color: #a5a5a5;
  border-radius: 5px;
  transition: color 0.18s, background 0.18s;
}

.social-icons a:hover {
  color: #fff;
  background: #23272b;
}

.social-icons a:hover {
  color: #fff;
  background: #23272b;
}

/* Accordion styles for mobile */
@media (max-width: 767.98px) {
  .footer-accordion {
    margin-bottom: 15px;
  }
  
  .footer-accordion .accordion-button {
    background-color: transparent;
    color: white;
    padding: 15px 0;
    box-shadow: none;
    border-bottom: 1px solid rgba(255,255,255,0.1);
  }
  
  .footer-accordion .accordion-button:not(.collapsed) {
    background-color: transparent;
    color: white;
  }
  
  .footer-accordion .accordion-button::after {
    filter: brightness(0) invert(1);
  }
  
  .footer-accordion .accordion-body {
    padding: 15px 0;
  }
  
  .footer-accordion .social-icons {
    flex-direction: row !important;
    justify-content: center;
    gap: 15px;
    padding: 10px 0;
  }
  
  .footer-accordion .social-icons li {
    margin: 0;
  }
}
</style>

<footer class="footer-02 mt-auto">
  <div class="container">
    <div class="row justify-content-center d-none d-md-flex">
      <div class="col-md-4 col-lg-5">
        <div class="row">
          <div class="col-md-12 col-lg-8 mb-md-0 mb-4">
            <h2 class="footer-heading"><a href="#" class="logo">Socialicar</a></h2>
            <p>
              SocialiCar es un intermediario destinado al alquiler de vehículos entre particulares. La idea surge ante la creciente necesidad de alternativas de movilidad más flexibles, accesibles y sostenibles.
            </p>
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
            <ul class="list-unstyled social-icons">
              <li><a href="https://www.facebook.com/people/SocialiCar-Rentacar/pfbid0eL6UbpgSWBv5jxYF5SV32DuJF645MRwvcVb1KXnVPvWNbfs8NYWQeHpUntVefi23l/" class="py-1 d-block" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i> <span class="visually-hidden">Facebook</span></a></li>
              <li><a href="https://x.com/socialicar_" class="py-1 d-block" target="_blank" rel="noopener"><i class="fab fa-x-twitter"></i> <span class="visually-hidden">Twitter</span></a></li>
              <li><a href="https://www.instagram.com/socialicar/" class="py-1 d-block" target="_blank" rel="noopener"><i class="fab fa-instagram"></i> <span class="visually-hidden">Instagram</span></a></li>
              <li><a href="https://www.tiktok.com/@socialicar" class="py-1 d-block" target="_blank" rel="noopener"><i class="fab fa-tiktok"></i> <span class="visually-hidden">TikTok</span></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Mobile accordion version -->
    <div class="accordion d-md-none footer-accordion" id="footerAccordion">
      <div class="accordion-item border-0 bg-transparent">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
            Información
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#footerAccordion">
          <div class="accordion-body">
            <ul class="list-unstyled">
              <li><a href="/src/pages/informacion/proposito.php" class="py-1 d-block">Sobre nosotros</a></li>
              <li><a href="/src/pages/informacion/contacto.php" class="py-1 d-block">Contacto</a></li>
              <li><a href="/src/pages/informacion/trabaja.php" class="py-1 d-block">Trabaja con nosotros</a></li>
              <li><a href="/src/pages/informacion/soporte.php" class="py-1 d-block">Atencion al cliente</a></li>
            </ul>
          </div>
        </div>
      </div>
      
      <div class="accordion-item border-0 bg-transparent">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
            Alquiler de coches
          </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#footerAccordion">
          <div class="accordion-body">
            <ul class="list-unstyled">
              <li><a href="/src/pages/coche/nuevo_coche.php" class="py-1 d-block">Alquila tu coche</a></li>
              <li><a href="/src/pages/rentacar/mostrar_coches.php" class="py-1 d-block">Encontrar un coche</a></li>
              <li><a href="/src/pages/usuario/planes.php" class="py-1 d-block">Planes</a></li>
              <li><a href="/src/pages/informacion/ayuda.php" class="py-1 d-block">Guia</a></li>
            </ul>
          </div>
        </div>
      </div>
      
      <div class="accordion-item border-0 bg-transparent">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
            Legal
          </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#footerAccordion">
          <div class="accordion-body">
            <ul class="list-unstyled">
              <li><a href="/src/pages/informacion/aviso_legal.php" class="py-1 d-block">Aviso legal</a></li>
              <li><a href="/src/pages/informacion/politica_privacidad.php" class="py-1 d-block">Politica de privacidad</a></li>
              <li><a href="/src/pages/informacion/politica_cookies.php" class="py-1 d-block">Cookies</a></li>
              <li><a href="/src/pages/informacion/accesibilidad.php" class="py-1 d-block">Accesibilidad</a></li>
            </ul>
          </div>
        </div>
      </div>
      
      <div class="accordion-item border-0 bg-transparent">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
            Redes sociales
          </button>
        </h2>
        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#footerAccordion">
          <div class="accordion-body">
            <ul class="list-unstyled social-icons">
              <li><a href="https://www.facebook.com/people/SocialiCar-Rentacar/pfbid0eL6UbpgSWBv5jxYF5SV32DuJF645MRwvcVb1KXnVPvWNbfs8NYWQeHpUntVefi23l/" class="py-1 d-block" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i> <span class="visually-hidden">Facebook</span></a></li>
              <li><a href="https://x.com/socialicar_" class="py-1 d-block" target="_blank" rel="noopener"><i class="fab fa-x-twitter"></i> <span class="visually-hidden">Twitter</span></a></li>
              <li><a href="https://www.instagram.com/socialicar/" class="py-1 d-block" target="_blank" rel="noopener"><i class="fab fa-instagram"></i> <span class="visually-hidden">Instagram</span></a></li>
              <li><a href="https://www.tiktok.com/@socialicar" class="py-1 d-block" target="_blank" rel="noopener"><i class="fab fa-tiktok"></i> <span class="visually-hidden">TikTok</span></a></li>
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
              <a href="#"><span class="ion-logo-ionic mr-2"></span>Pablo Monís Álvarez</a>
              <a href="#"><span class="ion-logo-ionic mr-2"></span>Francisco Cortés Pirson</a>
              <a href="#"><span class="ion-logo-ionic mr-2"></span>Raul Martín González</a>
              <a href="#"><span class="ion-logo-ionic mr-2"></span>Ismael de la Rosa Guerrero</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/src/js/main.js"></script>