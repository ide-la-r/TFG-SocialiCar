<nav class="navbar navbar-expand-lg navbar-light custom-navbar">
    <div class="container-fluid">
        <button
            class="navbar-toggler ps-3 border-0"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
            style="outline: none !important; box-shadow: none !important;">
            <i class="fas fa-bars"></i>
        </button>

        <a class="navbar-brand mt-2 mt-lg-0 logo ps-3" href="/">
            <img
                src="/src/img/LogoSocialicar.png"
                alt="SocialiCar Logo"
                loading="lazy" />
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ps-3 ps-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/src/pages/rentacar/mostrar_coches">Alquiler</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link premium-link" href="/src/pages/usuario/planes">
                        Premium <i class="fa-solid fa-star "></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/src/pages/informacion/contacto">Contacto</a>
                </li>

                <li class="nav-item d-lg-none">
                    <?php
                    if (isset($_SESSION['usuario'])) {
                        echo "<a class='btn-alquila-mobile' href='/src/pages/coche/nuevo_coche'>
                        <i class='fa-solid fa-car-side me-2'></i> Alquila tu coche </a>";
                    }
                    ?>
                </li>
            </ul>
        </div>

        <div class="d-flex align-items-center pe-3">
            <?php
            if (isset($_SESSION['usuario'])) {
                echo "<a class='btn btn-custom me-3 d-none d-lg-inline-block' href='/src/pages/coche/nuevo_coche'>
                <i class='fa-solid fa-car-side me-2'></i> Alquila tu coche </a>";
            }
            ?>

            <?php
            if (isset($_SESSION['usuario'])) {
                echo "
                    <a href='/src/pages/chat/conversa' class='btn btn-outline-primary d-flex align-items-center me-3'>
                        <i class='bi bi-chat-dots me-2'></i>
                        <span class='d-none d-lg-inline'>Chat</span>
                    </a>
                ";
            }
            ?>

            <div class="dropdown-js">
                <a class="dropdown-toggle-js d-flex align-items-center hidden-arrow"
                    href="#"
                    id="navbarDropdownMenuAvatar-js"
                    role="button"
                    aria-haspopup="true"
                    aria-expanded="false"
                    tabindex="0">
                    <?php
                    if (!isset($_SESSION['usuario'])) {
                        echo '<img style="object-fit: cover; border-radius: 50%; overflow: hidden; border: 4px solid #6BBFBF; background-color: #F2F2F2;" src="/src/img/perfil.png" class="rounded-circle" height="35" alt="Avatar" loading="lazy" />';
                    } else {
                        $sql = $_conexion->prepare("SELECT foto_perfil FROM usuario WHERE identificacion = ?");
                        $sql->bind_param("s", $_SESSION['usuario']['identificacion']);
                        $sql->execute();
                        $resultado = $sql->get_result();

                        if ($resultado->num_rows > 0) {
                            $fila = $resultado->fetch_assoc();
                            $foto_perfil = $fila['foto_perfil'];

                            if (!empty($foto_perfil)) {
                                echo '<img style="object-fit: cover; border-radius: 50%; overflow: hidden; border: 2px solid #6BBFBF; background-color: #F2F2F2;" src="' . htmlspecialchars($foto_perfil) . '" class="rounded-circle" height="35" width="35" alt="Avatar" loading="lazy" />';
                            } else {
                                echo '<img style="object-fit: cover; border-radius: 50%; overflow: hidden; border: 2px solid #6BBFBF; background-color: #F2F2F2;" src="/src/img/perfil.png" class="rounded-circle" height="35" alt="Avatar" loading="lazy" />';
                            }
                        } else {
                            echo '<img src="/src/img/perfil.png" class="rounded-circle" height="30" alt="Avatar" loading="lazy" />';
                        }
                    }
                    ?>
                    <span class="dropdown-arrow">&#9660;</span>
                </a>

                <ul class="dropdown-menu-js dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar-js">
                    <?php
                    if (isset($_SESSION['usuario'])) {
                        echo "
                            <li>
                                <a class='dropdown-item' href='/src/pages/usuario/perfil_usuario'>
                                    <i class='fa-regular fa-circle-user me-2'></i> Mi perfil
                                </a>
                            </li>
                            <li>
                                <a class='dropdown-item' href='/src/pages/usuario/cerrar_sesion'>
                                    <i class='fa-regular fa-circle-xmark me-2'></i> Cerrar sesión
                                </a>
                            </li>
                        ";
                    } else {
                        echo "
                            <li>
                                <a class='dropdown-item' href='/src/pages/usuario/iniciar_sesion'>
                                    <i class='fa-regular fa-circle-user me-2'></i> Iniciar sesión
                                </a>
                            </li>
                            <li>
                                <a class='dropdown-item' href='/src/pages/usuario/registro'>
                                    <i class='fa-regular fa-circle-user me-2'></i> Registrarse
                                </a>
                            </li>
                        ";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownToggle = document.querySelector('.dropdown-toggle-js');
        const dropdownMenu = document.querySelector('.dropdown-menu-js');
        const dropdownArrow = document.querySelector('.dropdown-arrow');

        if (dropdownToggle && dropdownMenu && dropdownArrow) {
            dropdownToggle.addEventListener('click', function(event) {
                event.preventDefault();

                // Alternar clase 'show'
                dropdownMenu.classList.toggle('show');

                // Girar flecha
                const isShown = dropdownMenu.classList.contains('show');
                dropdownArrow.style.transform = isShown ? 'rotate(180deg)' : 'rotate(0deg)';

                // Actualizar accesibilidad
                dropdownToggle.setAttribute('aria-expanded', isShown ? 'true' : 'false');
            });

            // Cerrar menú si se hace clic fuera
            document.addEventListener('click', function(event) {
                if (
                    !dropdownToggle.contains(event.target) &&
                    !dropdownMenu.contains(event.target) &&
                    dropdownMenu.classList.contains('show')
                ) {
                    dropdownMenu.classList.remove('show');
                    dropdownArrow.style.transform = 'rotate(0deg)';
                    dropdownToggle.setAttribute('aria-expanded', 'false'); // También cerramos accesibilidad
                }
            });
        }
    });
</script>