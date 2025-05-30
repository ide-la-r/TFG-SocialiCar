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
    <link rel="stylesheet" href="../../../src/styles/conversa.css">
    <?php include_once '../../components/links.php'; ?>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            
            background-image: url('../../../src/img/papel_roto.jpeg') !important;
            color: var(--dark-color);
            
        }

        .chat-wrapper {
            display: flex;
            max-width: 1200px;
            margin: 2rem auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background: white;
            height: calc(100vh - 200px);
        }

        .container.izquierda {
            flex: 1;
            border-right: 1px solid #e9ecef;
            background:rgba(121, 179, 191, 0.17) !important;
            overflow-y: auto;
            padding: 0;

        }

        .container.derecha {
            flex: 2;
            display: flex;
            flex-direction: column;
            background:rgb(240, 253, 255);
            
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
            background-color: white;
        }

        .chat-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            text-decoration: none;
            color: var(--dark-color);
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

        /* Chat area */
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
            background-image: url('../../../src/img/light-blue-background-13.jpg') !important;
            background-repeat: repeat;
            background-blend-mode: overlay;
        }

        .typing-area {
            display: flex;
            padding: 15px;
            
            background:rgb(221, 251, 255);
            border-radius: 70px;
            border: 1px solid grey;
        }

        .input-field {
            flex: 1;
            border: 1px solid #e9ecef;
            border-radius: 30px;
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
            background: var(--primary-color);
            color: white;
            margin-left: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .typing-area button:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .text-center {
            text-align: center;
            color: #6c757d;
            padding: 20px;
            background: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .chat-wrapper {
                flex-direction: column;
                height: auto;
            }

            .container.izquierda,
            .container.derecha {
                flex: none;
                width: 100%;
                
            }

            .container.izquierda {
                border-right: none;
                border-bottom: 1px solid #e9ecef;
                max-height: 300px;
            }
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

        .chat-item {
            animation: fadeIn 0.3s ease forwards;
        }

        .typing-area button {
            background-color: rgb(155, 227, 234) !important;
            transition: all 0.3s ease;
        }

        .typing-area button:hover {
            background-color: rgb(36, 196, 210) !important;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <?php include_once '../../components/navbar.php'; ?>

    <div class="chat-wrapper">
        <div class="container izquierda">
            <h3><i class="fas fa-comments mr-2"></i> Mis chats</h3>
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
                    <div class="text-center p-3">
                        <i class="fas fa-comment-slash fa-2x mb-2" style="color: #adb5bd;"></i>
                        <p>No tienes chats aún</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="container derecha">
            <section class="chat-area">
                <header style="border: 0.2px solid grey; border-radius: 50px; padding-bottom: 10px">
                    <a class="back-icon" href="/src/pages/rentacar/mostrar_coches">
                        <i class="fas fa-arrow-left" style="color: rgb(36, 196, 210) !important;"></i>
                    </a>
                    <?php if ($datos): ?>
                        <div class="details">
                            <div class="usuario-estado">
                                <span class="nombre-usuario"><?= htmlspecialchars($datos["nombre"]) ?></span>
                                <span class="estado <?= $estado === 'Online' ? 'online' : 'offline' ?>"></span>
                                <small class="ml-2"><?= $estado ?></small>
                            </div>
                            <p class="text-muted"><?= htmlspecialchars(($datos["marca"] ?? "") . " " . ($datos["modelo"] ?? "")) ?></p>
                        </div>
                    <?php elseif ($otro_usuario): ?>
                        <div class="details">
                            <div class="usuario-estado">
                                <span class="nombre-usuario"><?= htmlspecialchars($nombre ?? "Usuario") ?></span>
                                <span class="estado offline"></span>
                                <small class="ml-2">Offline</small>
                            </div>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="chat-box" id="chat-container" data-id-saliente="<?= $id_usuario ?>" data-id-entrante="<?= htmlspecialchars($otro_usuario ?? '') ?>">
                    <!-- Los mensajes se cargarán aquí -->
                    <?php if (!$otro_usuario): ?>
                        <div class="empty-chat text-center">
                            <i class="fas fa-comment-dots fa-3x mb-3" style="color: #e9ecef;"></i>
                            <h4>Selecciona un chat</h4>
                            <p class="text-muted">Elige una conversación para empezar a chatear</p>
                        </div>
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
                    <div class="text-center p-3 bg-light">
                        <p class="m-0 text-muted">Selecciona un chat para empezar a conversar.</p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </div><br>

    <?php include_once '../../components/footer-example.php'; ?>

    <script src="../../js/conversa.js"></script>

</body>

</html>