<style>
  .custom-navbar {
    background-color: #C4EEF2 !important;
  }

  .btn-custom {
    background-color: #6BBFBF;
    color: black;
    border: none;
  }

  .nav-item {
    padding-right: 20px;
  }

  .nav-item .nav-link {
    position: relative;
    padding-bottom: 5px;
  }

  .nav-item .nav-link::after {
    /* se encarga de subrayar */
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 3px;
    background-color: white;
    transform: scaleX(0);
    transform-origin: bottom right;
    transition: transform 0.3s ease;
  }

  .nav-item .nav-link:hover::after {
    /* se encarga de subrayar */
    transform: scaleX(1);
    transform-origin: bottom left;
  }

  .nav-item:hover .nav-link {
    color: white !important;
  }


  
  .premium-link .fa-star {
  color: rgb(252, 235, 121) !important;
  transition: transform 0.3s ease, color 0.3s ease; 
}

.premium-link:hover .fa-star {
  color: white !important; 
  animation: girarEstrella 1.5s infinite linear; 
}

@keyframes girarEstrella {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}



  .fa-solid {
    color: white;
  }

  .custom-navbar .btn-custom {
    color: white !important;
    /* sino, cambia de color */
    background-color: #6BBFBF;
    border: none;
  }

  .btn-custom:hover {
    background-color: #B0D5D9;
    color: black;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-light custom-navbar">
  <div class="container-fluid">
    <!-- Botón para móviles INICIAR SESION, REGISTRARSE, PREMIUM-->
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Logo -->
    <a class="navbar-brand mt-2 mt-lg-0" href="/socialicar/">
      <img
        src="/socialicar/src/img/nav.png"
        height="30"
        alt="SocialiCar Logo"
        loading="lazy" />
    </a>

    <!-- Contenido colapsable -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/socialicar/">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/socialicar/src/pages/rentacar/mostrar_coches">Alquilar Coche</a>
        </li>
        <li class="nav-item">
          <a class="nav-link premium-link" href="/socialicar/src/pages/usuario/planes">
            Premium <i class="fa-solid fa-star "></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/socialicar/src/pages/usuario/contacto">Contacto</a>
        </li>
      </ul>
    </div>

    <!-- Elementos a la derecha -->
    <div class="d-flex align-items-center">

      <!-- Botón de alquilar -->
      <a class="btn btn-custom me-3" href="/socialicar/src/pages/coche/nuevo_coche">
        <i class="fa-solid fa-car-side me-2"></i> Alquila tu coche
      </a>

      <!-- Notificaciones -->
      <div class="dropdown me-3">
        <a
          class="text-reset"
          href="#"
          role="button"
          data-bs-toggle="dropdown"
          aria-expanded="false">
          <i class="fa-regular fa-comment-dots fa-flip-horizontal"></i>
          <span class="badge rounded-pill bg-danger">1</span>
        </a>
      </div>

      <!-- Avatar usuario -->

      <div class="dropdown">
        <a class="dropdown-toggle d-flex align-items-center hidden-arrow"
          href="#"
          id="navbarDropdownMenuAvatar"
          role="button"
          data-bs-toggle="dropdown"
          aria-expanded="false">
          <img src="/socialicar/src/img/perfil.png" class="rounded-circle" height="30" alt="Avatar" loading="lazy" />
        </a>

        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
          <li>
            <a class="dropdown-item" href="/socialicar/src/pages/usuario/registro">
              <i class="fa-regular fa-circle-user me-2"></i> Registrarse
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="/socialicar/src/pages/usuario/iniciar_sesion">
              <i class="fa-regular fa-circle-user me-2"></i> Iniciar sesión
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="/socialicar/src/pages/usuario/perfil_usuario">
              <i class="fa-regular fa-circle-user me-2"></i> Mi perfil
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="/socialicar/src/pages/usuario/cerrar_sesion">
              <i class="fa-regular fa-circle-xmark me-2"></i> Cerrar sesión
            </a>
          </li>
        </ul>
      </div>

    </div>
  </div>
</nav>