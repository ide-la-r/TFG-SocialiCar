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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>SocialiCar - Chats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <?php include_once '../../components/links.php'; ?>

    <style>
        /* Variables CSS */
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #0dcaf0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --accent-color: #4895ef;
            --background-color: #f8f9fa;
            --chat-left-bg: rgba(121, 179, 191, 0.17);
            --chat-right-bg: #f0fdff;
            --message-sent: #0084ff;
            --message-received: #e4e6eb;
            --border-radius: 12px;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Reset y estilos generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-image: url('../../img/papel_roto.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            position: relative;
            min-height: 100vh;
            display: flex;
            background-position: center;
            flex-direction: column;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Oscurece el fondo */
            z-index: -1;
        }

        a {
            text-decoration: none;
            color: inherit;
        }


        /* Contenedor principal */
        .chat-wrapper {
            display: flex;
            margin: 2rem auto;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            background: white;
            width: 1000px;
            height: 650px;
            flex-grow: 1;
            border: 1px solid black;
        }

        /* Panel izquierdo - Lista de chats */
        .container.izquierda {
            flex: 1;
            border-right: 1px solid #e9ecef;
            background: var(--chat-left-bg);
            overflow-y: auto;
            padding: 0;
            display: flex;
            flex-direction: column;

            border-right: 1px solid black !important;
        }

        .container.izquierda h3 {
            padding: 1rem;
            margin: 0;
            background: rgb(155, 227, 234);
            color: white;
            font-size: 1.2rem;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .lista-chats {
            padding: 0;
            background-color: rgba(155, 227, 234, 0.32);
            flex-grow: 1;


        }

        .chat-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            text-decoration: none;
            border-bottom: 1px solid black !important;
            border-top: 1px solid black !important;
            background-color: white !important;
            transition: all 0.2s ease;
        }

        .chat-item:hover {
            background-color: #f1f3f5;
        }

        .chat-item img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 12px;
            border: 2px solid #e9ecef;
        }

        .contenido-chat {
            flex: 1;
            overflow: hidden;
        }

        .nombre {
            font-weight: 600;
            display: block;
            margin-bottom: 4px;
            color: var(--dark-color);
        }

        .mensaje {
            font-size: 0.9rem;
            color: #6c757d;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }

        .hora {
            font-size: 0.8rem;
            color: #adb5bd;
            margin-left: 10px;
        }

        /* Panel derecho - Área de chat */
        .container.derecha {
            flex: 2;
            display: flex;
            flex-direction: column;
            background: var(--chat-right-bg);
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
            background: white;
            border-bottom: 1px solid #e9ecef;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }


        .back-icon {
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-right: 15px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .details {
            flex: 1;
        }

        .usuario-estado {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .nombre-usuario {
            font-weight: 600;
            margin-right: 10px;
            color: var(--dark-color);
        }

        .estado {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .estado.online {
            background-color: var(--success-color);
        }

        .estado.offline {
            background-color: #adb5bd;
        }

        .chat-box {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-repeat: repeat;
            background-size: contain;
            display: flex;
            flex-direction: column;
        }

        .typing-area {
            display: flex;
            padding: 15px;
            background: rgb(221, 251, 255);
            border-radius: 70px;
            border: 1px solid rgba(84, 84, 84, 0.49);
            margin: 0 15px 15px;
            margin-top: 20px;
        }

        .input-field {
            flex: 1;
            border: 1px solid rgba(101, 101, 101, 0.38);
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            padding: 12px 20px;
            font-size: 1rem;
            outline: none;
            resize: none;
            height: 50px;
            transition: all 0.3s ease;
        }


        .input-field:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(72, 149, 239, 0.2);
        }

        .typing-area button {
            width: 50px;
            height: 50px;
            border: none;
            border-radius: 50%;
            background: rgb(155, 227, 234);
            color: white;
            margin-left: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .typing-area button:hover {
            background: rgb(36, 196, 210);
            transform: translateY(-2px);
        }

        /* Mensajes */
        .mensaje-wrapper {
            display: flex;
            margin-bottom: 15px;
        }

        .mensaje-enviado {
            justify-content: flex-end;
        }

        .mensaje-recibido {
            justify-content: flex-start;
        }

        .mensaje {
            max-width: 70%;
            padding: 12px 15px;
            border-radius: 18px;
            position: relative;
            word-wrap: break-word;
            animation: fadeIn 0.3s ease forwards;
        }

        .mensaje-derecha {
            background-color: rgb(255, 107, 218);
            color: white;
            border-bottom-right-radius: 0;
        }

        .mensaje-izquierda {
            background-color: var(--message-received);
            color: black;
            border-bottom-left-radius: 0;
        }

        .hora-mensaje {
            font-size: 0.75rem;
            opacity: 0.8;
            display: block;
            text-align: right;
            margin-top: 5px;
        }

        .mensaje-izquierda .hora-mensaje {
            color: #65676b;
        }

        .mensaje-derecha .hora-mensaje {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Estados vacíos */
        .text-center {
            text-align: center;
            color: #6c757d;
            padding: 20px;
            background: white;
        }

        .empty-chat {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #6c757d;
        }

        .empty-chat i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ced4da;
        }

        .empty-chat h4 {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-chat p {
            max-width: 300px;
        }

        /* Animaciones */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nombreUsuario {
            margin-left: -12px;
            margin-right: -12px;
            height: 57px;
            border-bottom: 1px solid black !important;
        }
    </style>
</head>

<body>
    <?php include_once '../../components/navbar.php'; ?>

    <div class="chat-wrapper">
        <div class="container izquierda">
            <h3><i class="fas fa-comments"></i> Mis chats</h3>
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
                ?>
                    <a href="conversa?chat_con=<?= urlencode($otro) ?>" class="chat-item">
                        <img src="<?= htmlspecialchars($foto) ?>" alt="Perfil de <?= htmlspecialchars($nombre) ?>">
                        <div class="contenido-chat">
                            <span class="nombre"><?= htmlspecialchars($nombre) ?></span>
                            <span class="mensaje"><?= $mensaje ?></span>
                        </div>
                        <div class="hora"><?= $hora ?></div>
                    </a>
                <?php endwhile; ?>

                <?php if ($resultado->num_rows === 0): ?>
                    <div class="text-center">
                        <i class="fas fa-comment-slash fa-2x" style="color: #adb5bd; margin: 20px 0 10px;"></i>
                        <p>No tienes chats aún</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="container derecha">
            <section class="chat-area">
                <header class="nombreUsuario">
                    <a class="back-icon" href="/src/pages/rentacar/mostrar_coches">
                        <i class="fas fa-arrow-left" style="color: rgb(36, 196, 210);"></i>
                    </a>
                    <?php if ($datos): ?>
                        <div class="details">
                            <div class="usuario-estado">
                                <span class="nombre-usuario"><?= htmlspecialchars($datos["nombre"]) ?></span>
                                <span class="estado <?= $estado === 'Online' ? 'online' : 'offline' ?>"></span>
                                <small><?= $estado ?></small>
                            </div>
                            <p style="color: #6c757d; font-size: 0.9rem;"><?= htmlspecialchars(($datos["marca"] ?? "") . " " . ($datos["modelo"] ?? "")) ?></p>
                        </div>
                    <?php elseif ($otro_usuario): ?>
                        <div class="details">
                            <div class="usuario-estado">
                                <span class="nombre-usuario"><?= htmlspecialchars($nombre ?? "Usuario") ?></span>
                                <span class="estado offline"></span>
                                <small>Offline</small>
                            </div>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="chat-box" id="chat-container" data-id-saliente="<?= $id_usuario ?>" data-id-entrante="<?= htmlspecialchars($otro_usuario ?? '') ?>">
                    <!-- Los mensajes se cargarán aquí -->
                    <?php if (!$otro_usuario): ?>
                        <div class="empty-chat">
                            <i class="fas fa-comment-dots"></i>
                            <h4>Selecciona un chat</h4>
                            <p>Elige una conversación para empezar a chatear</p>
                        </div>
                        <?php else:
                        // Cargar mensajes existentes
                        $mensajes_sql = $_conexion->prepare("
                            SELECT * FROM mensajes 
                            WHERE (id_mensaje_saliente = ? AND id_mensaje_entrante = ?) 
                               OR (id_mensaje_saliente = ? AND id_mensaje_entrante = ?) 
                            ORDER BY fecha_envio ASC
                        ");
                        $mensajes_sql->bind_param("ssss", $id_usuario, $otro_usuario, $otro_usuario, $id_usuario);
                        $mensajes_sql->execute();
                        $mensajes_result = $mensajes_sql->get_result();

                        while ($mensaje = $mensajes_result->fetch_assoc()):
                            $esMio = $mensaje['id_mensaje_saliente'] == $id_usuario;
                        ?>
                            <div class="mensaje-wrapper <?= $esMio ? 'mensaje-enviado' : 'mensaje-recibido' ?>">
                                <div class="mensaje <?= $esMio ? 'mensaje-derecha' : 'mensaje-izquierda' ?>">
                                    <p><?= htmlspecialchars($mensaje['mensaje']) ?></p>
                                    <span class="hora-mensaje"><?= date("H:i", strtotime($mensaje['fecha_envio'])) ?></span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>

                <?php if ($otro_usuario): ?>
                    <form class="typing-area" autocomplete="off" id="messageForm">
                        <textarea name="mensaje" class="input-field" id="mensajeInput" placeholder="Escribe un mensaje..." required></textarea>
                        <button type="submit" aria-label="Enviar mensaje">
                            <i class="fab fa-telegram-plane"></i>
                        </button>
                    </form>
                <?php else: ?>
                    <div style="text-align: center; padding: 15px; background: #f8f9fa; color: #6c757d;">
                        <p>Selecciona un chat para empezar a conversar.</p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
    <?php include_once '../../components/footer-example.php'; ?>

    <script>
        // Script para manejar el envío de mensajes
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('messageForm');

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const messageInput = document.getElementById('mensajeInput');
                    const message = messageInput.value.trim();

                    if (message) {
                        // Aquí iría la lógica para enviar el mensaje al servidor
                        console.log('Mensaje enviado:', message);

                        // Limpiar el campo de entrada
                        messageInput.value = '';
                    }
                });
            }

            // Scroll al final del chat
            const chatContainer = document.getElementById('chat-container');
            if (chatContainer) {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        });
    </script>
</body>

</html>