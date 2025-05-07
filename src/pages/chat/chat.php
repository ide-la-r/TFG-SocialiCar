<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Chat</title>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="../../../src/styles/chat.css">
    <?php include_once '../../components/links.php'; ?>

    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        require(__DIR__ . "/../../config/conexion.php");
        session_start();

        $matricula = $_GET['matricula'] ?? null;

        $datos = [];
        if ($matricula) {
            $sql = $_conexion->prepare("
                SELECT c.*, u.*
                FROM coche c
                JOIN usuario u ON c.id_usuario = u.identificacion
                WHERE c.matricula = ?
            ");
            $sql->bind_param("s", $matricula);
            $sql->execute();
            $resultado = $sql->get_result();
            
            if ($resultado->num_rows > 0) {
                $datos = $resultado->fetch_assoc();
            }
        }

        $estado = (!empty($datos) && $datos["estado"] == 0) ? "Offline" : "Online";
    ?>
</head>
<body>
    <?php include_once '../../components/navbar.php'; ?>

    <div class="chat-wrapper">
        <div class="container izquierda">
            <h3>Mis chats</h3>
        </div>

        <div class="container derecha">
            <section class="chat-area">
                <header>
                    <a class="back-icon" href="/src/pages/rentacar/coche?matricula=<?= htmlspecialchars($matricula) ?>">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <img src="<?= htmlspecialchars($datos["foto_perfil"] ?? '../../../src/img/default-profile.png') ?>" alt="Foto de perfil">
                    <div class="details">
                        <div class="usuario-estado">
                            <span class="nombre-usuario"><?= htmlspecialchars($datos["nombre"]) ?></span>
                            <span class="estado <?= $estado === 'Online' ? 'online' : 'offline' ?>"></span>
                        </div>
                        <p><?= htmlspecialchars(($datos["marca"] ?? "") . " " . ($datos["modelo"] ?? "")) ?></p>
                    </div>
                </header>

                <div class="chat-box">
                    <!-- Aquí aparecerán los mensajes -->
                </div>

                <form action="#" class="typing-area" autocomplete="off">
                    <input type="text" class="mensaje_entrante" name="mensaje_entrante" hidden>
                    <input type="text" class="input-field" name="mensaje" placeholder="Escribe un mensaje...">
                    <button type="submit">
                        <i class="fab fa-telegram-plane"></i>
                    </button>
                </form>
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
