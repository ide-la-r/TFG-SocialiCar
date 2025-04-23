<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <!-- Botón para móviles -->
    <button
      class="navbar-toggler"
      type="button"
      data-mdb-toggle="collapse"
      data-mdb-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
      style="border: none; background-color: transparent;"
    >
      <i class="fas fa-bars"></i>
    </button>

    <!-- Logo -->
    <a class="navbar-brand mt-2 mt-lg-0" href="index.php">
      <img
        src="src/img/nav.png"
        height="30"
        alt="SocialiCar Logo"
        loading="lazy"
      />
    </a>

    <!-- Contenido colapsable -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="alquilar.php">Alquilar Coche</a>
        </li>
      </ul>
    </div>

    <!-- Elementos a la derecha -->
    <div class="d-flex align-items-center">

      <!-- Notificaciones -->
      <div class="dropdown me-3">
        <a
          class="text-reset"
          href="#"
          role="button"
          aria-expanded="false"
        >
          <i class="fa-regular fa-comment-dots fa-flip-horizontal"></i>
          <span class="badge rounded-pill bg-danger">1</span>
        </a>
      </div>

      <!-- Avatar usuario -->
      <div class="dropdown">
        <a
          class="dropdown-toggle d-flex align-items-center hidden-arrow"
          href="#"
          id="navbarDropdownMenuAvatar"
          role="button"
          data-mdb-toggle="dropdown"
          aria-expanded="false"
        >
          <img
            src="src/img/perfil.png"
            class="rounded-circle"
            height="30"
            alt="Avatar"
            loading="lazy"
          />
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
          <li>
            <a class="dropdown-item" href="#">
              <i class="fa-regular fa-circle-user me-2"></i> Mi perfil
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="#">
              <i class="fa-regular fa-circle-question me-2"></i> Configuración
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="#">
              <i class="fa-regular fa-circle-xmark me-2"></i> Cerrar sesión
            </a>
          </li>
        </ul>
      </div>

    </div>
  </div>
</nav>
