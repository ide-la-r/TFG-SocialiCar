<?php
require(__DIR__ . "/../../config/conexion.php");
session_start();

$id_usuario = $_SESSION["usuario"]["identificacion"];
$otro_usuario = $_GET['chat_con'] ?? null;

if ($otro_usuario !== null && $id_usuario === $otro_usuario) {
    echo "No puedes enviarte mensajes a ti mismo.";
    exit();
}

// Verifica si estamos en un chat específico con un coche (matricula)
$matricula = $_GET['matricula'] ?? null;

if ($matricula !== null) {
    // Obtener los datos del coche solo si se pasa la matrícula
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

    $estado = (!empty($datos) && $datos["estado"] == 0) ? "Offline" : "Online";
} else {
    // Si no hay matrícula, no se pueden mostrar los datos del coche
    $datos = null;
    $estado = "Offline";  // Por defecto
}

// Obtener información del usuario con el que se chatea
$nombre_chat = "Selecciona un chat";
$foto_chat = '../../../src/img/default-profile.png';
if ($otro_usuario) {
    $sql_usuario_chat = $_conexion->prepare("SELECT nombre, foto_perfil FROM usuario WHERE identificacion = ?");
    $sql_usuario_chat->bind_param("s", $otro_usuario);
    $sql_usuario_chat->execute();
    $resultado_usuario_chat = $sql_usuario_chat->get_result();

    if ($resultado_usuario_chat->num_rows > 0) {
        $usuario_chat = $resultado_usuario_chat->fetch_assoc();
        $nombre_chat = $usuario_chat["nombre"];
        $foto_chat = !empty($usuario_chat["foto_perfil"]) ? $usuario_chat["foto_perfil"] : '../../../src/img/default-profile.png';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>SocialiCar - Mis Chats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="../../../src/styles/conversa.css">
    <?php include_once '../../components/links.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --light-color: #f8f9fa;
        --dark-color: #212529;
        --success-color: #4bb543;
        --online-color: #4bb543;
        --offline-color: #ccc;
    }


    body {
        background-image: url('../../img/fondo_amarillo.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }


    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f5f7fb;
    }

    .chat-wrapper {
        width: 90%;
        max-width: 1200px;
        height: 80vh;
        margin: 2rem auto;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        display: flex;
        background-color: white;
    }

    .izquierda {
        flex: 1;
        border-right: 1px solid #e9ecef;
        padding: 0;
        display: flex;
        flex-direction: column;
        background-color: #fff;
    }

    .derecha {
        flex: 2;
        padding: 0;
        display: flex;
        flex-direction: column;
        background-color: #f8f9fa;
    }

    .lista-chats {
        flex: 1;
        overflow-y: auto;
        padding: 0;

        background-color: rgb(249, 252, 255) !important;
    }

    .chat-header {
        padding: 1rem;
        background-color: #6BBFBF;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chat-header h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .chat-area {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .chat-area header {
        display: flex;
        align-items: center;
        padding: 15px;
        background-color: white;
        border-bottom: 1px solid #e9ecef;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .chat-area header img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
    }

    .chat-area header .details {
        flex: 1;
    }

    .chat-area header .details .nombre-usuario {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--dark-color);
    }

    .chat-area header .details p {
        margin: 0;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .usuario-estado {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .estado {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }

    .estado.online {
        background-color: var(--online-color);
    }

    .estado.offline {
        background-color: var(--offline-color);
    }

    .back-icon {
        color: var(--dark-color);
        font-size: 1.2rem;
        margin-right: 15px;
        text-decoration: none;
    }

    .back-icon:hover {
        color: var(--primary-color);
    }

    .chat-box {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        background-color: #f8f9fa;
        background-image: url('../../../src/img/chat-bg.png');
        background-repeat: repeat;
        background-position: center;
    }

    .typing-area {
        padding: 15px;
        display: flex;
        background-color: white;
        border-top: 1px solid #e9ecef;
        margin-bottom: 0;
        margin-top: -20px;
    }

    .typing-area textarea {
        flex: 1;
        border: 1px solid #e9ecef;
        border-radius: 30px;
        padding: 12px 20px;
        font-size: 0.95rem;
        resize: none;
        outline: none;
        height: 50px;
        transition: all 0.3s;
    }

    .typing-area textarea:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
    }

    .typing-area button {
        width: 50px;
        height: 50px;
        border: none;
        border-radius: 50%;
        background-color: var(--primary-color);
        color: white;
        margin-left: 10px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .typing-area button:hover {
        background-color: var(--secondary-color);
    }

    .chat-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        border-bottom: 1px solid #f1f1f1;
        transition: all 0.3s;
        text-decoration: none;
        color: var(--dark-color);
    }

    .chat-item:hover {
        background-color: #f8f9fa;
    }

    .chat-item.active {
        background-color: #e9f5ff;
    }

    .chat-item img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
    }

    .chat-info {
        flex: 1;
    }

    .chat-info .chat-name {
        font-weight: 600;
        margin-bottom: 3px;
    }

    .chat-info .last-message {
        font-size: 0.85rem;
        color: #6c757d;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chat-time {
        font-size: 0.8rem;
        color: #adb5bd;
    }

    .no-chats {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        padding: 2rem;
        color: #6c757d;
        text-align: center;
    }

    .no-chats i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #dee2e6;
    }

    .select-chat {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        padding: 2rem;
        color: #6c757d;
        text-align: center;
    }

    .select-chat i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #dee2e6;
    }

    @media (max-width: 768px) {
        .chat-wrapper {
            flex-direction: column;
            height: auto;
        }

        .izquierda,
        .derecha {
            width: 100%;
        }

        .izquierda {
            border-right: none;
            border-bottom: 1px solid #e9ecef;
        }
    }

    .nombreUsuario {
        background-color: rgb(244, 250, 255) !important;
        margin-bottom: 0;
    }
</style>

<body>
    <?php include_once '../../components/navbar.php'; ?>

    <div class="chat-wrapper">
        <div class="izquierda">
            <div class="chat-header">
                <h2>Mis chats</h2>
            </div>
            <div class="lista-chats">
                <?php
                $sql = $_conexion->prepare("
                    SELECT 
                        IF(m.id_mensaje_saliente = ?, m.id_mensaje_entrante, m.id_mensaje_saliente) AS otro_usuario,
                        MAX(m.fecha_envio) AS ultima_fecha,
                        (SELECT mensaje FROM mensajes 
                         WHERE (id_mensaje_saliente = ? AND id_mensaje_entrante = otro_usuario) 
                            OR (id_mensaje_saliente = otro_usuario AND id_mensaje_entrante = ?) 
                         ORDER BY fecha_envio DESC LIMIT 1) AS ultimo_mensaje
                    FROM mensajes m
                    WHERE m.id_mensaje_saliente = ? OR m.id_mensaje_entrante = ?
                    GROUP BY otro_usuario
                    ORDER BY ultima_fecha DESC
                ");
                $sql->bind_param("sssss", $id_usuario, $id_usuario, $id_usuario, $id_usuario, $id_usuario);
                $sql->execute();
                $resultado = $sql->get_result();

                if ($resultado->num_rows > 0):
                    while ($fila = $resultado->fetch_assoc()):
                        $otro = $fila["otro_usuario"];
                        $usuario_stmt = $_conexion->prepare("SELECT nombre, foto_perfil FROM usuario WHERE identificacion = ?");
                        $usuario_stmt->bind_param("s", $otro);
                        $usuario_stmt->execute();
                        $usuario_data = $usuario_stmt->get_result()->fetch_assoc();

                        $nombre = $usuario_data["nombre"] ?? "Usuario";
                        $foto = !empty($usuario_data["foto_perfil"]) ? $usuario_data["foto_perfil"] : '/src/img/perfil.png';
                        $mensaje = htmlspecialchars($fila["ultimo_mensaje"]);
                        $hora = date("H:i", strtotime($fila["ultima_fecha"]));
                        $active_class = ($otro_usuario == $otro) ? 'active' : '';
                ?>
                        <a href="conversa?chat_con=<?= urlencode($otro) ?>" class="chat-item <?= $active_class ?>">
                            <img src="<?= htmlspecialchars($foto) ?>" alt="Perfil">
                            <div class="chat-info">
                                <div class="chat-name"><?= htmlspecialchars($nombre) ?></div>
                                <div class="last-message"><?= $mensaje ?></div>
                            </div>
                            <div class="chat-time"><?= $hora ?></div>
                        </a>
                    <?php endwhile;
                else: ?>
                    <div class="no-chats">
                        <i class="fas fa-comment-slash"></i>
                        <p>No tienes chats aún</p>
                        <p class="small">Inicia una conversación con otro usuario</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="derecha">
            <section class="chat-area">
                <header class="nombreUsuario">
                    <a class="back-icon" href="/src/pages/rentacar/mostrar_coches">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <?php if ($otro_usuario): ?>
                        <img src="<?= htmlspecialchars($foto_chat) ?>" alt="Foto de perfil">
                        <div class="details">
                            <div class="usuario-estado">
                                <span class="nombre-usuario"><?= htmlspecialchars($nombre_chat) ?></span>
                                <span class="estado <?= $estado === 'Online' ? 'online' : 'offline' ?>"></span>
                            </div>
                            <?php if ($datos): ?>
                                <p><?= htmlspecialchars(($datos["marca"] ?? "") . " " . ($datos["modelo"] ?? "")) ?></p>
                            <?php else: ?>
                                <p>Usuario de SocialiCar</p>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                    <?php endif; ?>
                </header>

                <?php if ($otro_usuario): ?>
                    <div class="chat-box" id="chat-container" data-id-saliente="<?= $id_usuario ?>" data-id-entrante="<?= htmlspecialchars($otro_usuario) ?>">
                        <!-- Los mensajes se cargarán aquí -->
                    </div>

                    <form class="typing-area" autocomplete="off" id="messageForm">
                        <textarea name="mensaje" class="input-field" id="mensajeInput" placeholder="Escribe un mensaje..."></textarea>
                        <button type="submit" style="background-color: #6BBFBF"><i class="fab fa-telegram-plane"></i></button>
                    </form>
                <?php else: ?>
                    <div class="select-chat" style="height: 100%;">
                        <i class="fas fa-comments"></i>
                        <h3>Selecciona un chat</h3>
                        <p>Elige una conversación de la lista para empezar a chatear</p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </div>

    <script src="../../js/conversa.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <script>
        // Función para mantener el scroll abajo en el chat
        function scrollToBottom() {
            const chatContainer = document.getElementById('chat-container');
            if (chatContainer) {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        }

        // Llamar a la función cuando se cargue la página y cuando se reciban nuevos mensajes
        document.addEventListener('DOMContentLoaded', scrollToBottom);
    </script>
</body>

</html>