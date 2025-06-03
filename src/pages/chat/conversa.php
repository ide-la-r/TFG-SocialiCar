<?php
require(__DIR__ . "/../../config/conexion.php");
session_start();

$id_usuario_actual = $_SESSION["usuario"]["identificacion"];
$id_chat_con_usuario = $_GET['chat_con'] ?? null;

if ($id_chat_con_usuario !== null && $id_usuario_actual === $id_chat_con_usuario) {
    echo "No puedes enviarte mensajes a ti mismo.";
    exit();
}

$matricula_vehiculo = $_GET['matricula'] ?? null;

// Variables para la cabecera del chat
$nombre_en_cabecera = "Usuario";
$estado_en_cabecera = "Offline";
$datos_coche_en_cabecera = null;
$id_propietario_coche = null;

// 1. Obtener datos del coche si se proporciona matrícula
if ($matricula_vehiculo !== null) {
    $sql_coche = $_conexion->prepare("
        SELECT c.*, u.identificacion as propietario_id, u.nombre as propietario_nombre, u.estado as propietario_estado, u.foto_perfil as propietario_foto
        FROM coche c
        JOIN usuario u ON c.id_usuario = u.identificacion
        WHERE c.matricula = ?
    ");
    $sql_coche->bind_param("s", $matricula_vehiculo);
    $sql_coche->execute();
    $resultado_coche = $sql_coche->get_result();

    if ($resultado_coche->num_rows > 0) {
        $datos_coche_en_cabecera = $resultado_coche->fetch_assoc();
        $id_propietario_coche = $datos_coche_en_cabecera['propietario_id'];
    }
}

// 2. Determinar la información a mostrar en la cabecera del chat
if ($id_chat_con_usuario !== null) {
    // Estamos en un chat específico
    if ($datos_coche_en_cabecera && $id_chat_con_usuario === $id_propietario_coche) {
        // Chat con el propietario del coche (contexto del coche)
        $nombre_en_cabecera = $datos_coche_en_cabecera['propietario_nombre'];
        $estado_en_cabecera = ($datos_coche_en_cabecera['propietario_estado'] == 1) ? "Online" : "Offline";
    } else {
        // Chat general con id_chat_con_usuario, o con alguien que no es el propietario del coche (si matricula está seteada)
        $sql_usuario_chat = $_conexion->prepare("SELECT nombre, estado FROM usuario WHERE identificacion = ?");
        $sql_usuario_chat->bind_param("s", $id_chat_con_usuario);
        $sql_usuario_chat->execute();
        $resultado_usuario_chat = $sql_usuario_chat->get_result();
        if ($usuario_info = $resultado_usuario_chat->fetch_assoc()) {
            $nombre_en_cabecera = $usuario_info['nombre'];
            $estado_en_cabecera = ($usuario_info['estado'] == 1) ? "Online" : "Offline";
        }
    }
} elseif ($datos_coche_en_cabecera) {
    // No hay chat_con, pero sí matrícula: Mostrar info del propietario para iniciar chat
    $nombre_en_cabecera = $datos_coche_en_cabecera['propietario_nombre'];
    $estado_en_cabecera = ($datos_coche_en_cabecera['propietario_estado'] == 1) ? "Online" : "Offline";
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
            --message-sent-bg: #ff6bda; /* ROSA para mensajes enviados */
            --message-received-bg: #e4e6eb; /* GRIS para mensajes recibidos */
            --message-sent-text-color: white;
            --message-received-text-color: black;
            --border-radius: 12px;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark-color);
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .chat-wrapper {
            display: flex;
            margin: 2rem auto;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            background: white;
            width: 1000px;
            height: 650px;
            border: 1px solid black;
        }

        .container.izquierda {
            flex: 1;
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
            display: flex;
            align-items: center;
        }
        .container.izquierda h3 i {
            margin-right: 0.75rem;
        }

        .lista-chats {
            padding: 0;
            background-color: rgba(155, 227, 234, 0.32);
            flex-grow: 1;
        }
        .lista-chats .placeholder-no-chats { 
            text-align: center;
            color: #6c757d;
            padding: 20px; 
        }
        .lista-chats .placeholder-no-chats i { 
            margin: 20px 0 10px;
            color: #adb5bd;
        }

        .chat-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            text-decoration: none;
            border-bottom: 1px solid black !important;
            border-top: 1px solid black !important;
            background-color: white !important;
            transition: all 0.2s ease;
            color: var(--dark-color);
        }

        .chat-item:hover {
            background-color: #f1f3f5 !important;
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
        .contenido-chat .nombre {
            font-weight: 600;
            display: block;
            margin-bottom: 4px;
            color: var(--dark-color);
        }
        .contenido-chat .mensaje {
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
        
        .chat-area header.nombreUsuario {
            display: flex;
            align-items: center;
            padding: 15px;
            background: white;
            margin-left: -12px;
            margin-right: -12px;
            height: 57px;
            border-bottom: 1px solid black !important;
        }

        .back-icon {
            font-size: 1.2rem;
            margin-right: 15px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
         .back-icon i {
             color: rgb(36, 196, 210) !important;
        }

        .details {
            flex: 1;
        }
        .details .car-info { 
            font-size: 0.9rem;
            color: #6c757d;
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

        .estado.online { background-color: var(--success-color); }
        .estado.offline { background-color: #adb5bd; }

        .chat-box {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-repeat: repeat;
            background-size: contain;
            display: flex;
            flex-direction: column;
        }
        .chat-box .empty-chat-placeholder { 
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #6c757d;
        }
        .chat-box .empty-chat-placeholder i { 
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ced4da;
        }
        .chat-box .empty-chat-placeholder h4 {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .chat-box .empty-chat-placeholder p {
            max-width: 300px;
        }

        .typing-area {
            display: flex;
            align-items: center;
            padding: 15px;
            background: rgb(221, 251, 255);
            border-radius: 70px;
            border: 1px solid rgba(84, 84, 84, 0.49);
            margin: 20px 15px 15px 15px;
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
            line-height: 1.4; 
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
            margin-left: 0px;
            border-left: none;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-top-right-radius: 30px;
            border-bottom-right-radius: 30px;
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
        
        .select-chat-prompt { 
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
        }
        .select-chat-prompt p { 
            margin: 0;
            color: #6c757d;
        }
        
        /* ESTILOS PARA DIFERENCIAR MENSAJES */
        .mensaje-wrapper {
            display: flex !important;
            margin-bottom: 15px !important;
            animation: fadeIn 0.3s ease forwards !important;
        }
        .mensaje-enviado { 
            justify-content: flex-end !important; /* Alineación derecha */
        }
        .mensaje-recibido { 
            justify-content: flex-start !important; /* Alineación izquierda */
        }

        .mensaje-wrapper .mensaje {
            max-width: 70% !important;
            padding: 12px 15px !important;
            border-radius: 18px !important;
            position: relative !important;
            word-wrap: break-word !important;
            line-height: 1.4 !important;
        }
        .mensaje-wrapper .mensaje p { margin: 0 !important; }

        /* Mensajes enviados (derecha) - ROSA */
        .mensaje.mensaje-derecha {
            background-color: var(--message-sent-bg) !important;
            color: var(--message-sent-text-color) !important;
            border-bottom-right-radius: 0px !important;
        }
        
        /* Mensajes recibidos (izquierda) - GRIS */
        .mensaje.mensaje-izquierda {
            background-color: var(--message-received-bg) !important;
            color: var(--message-received-text-color) !important;
            border-bottom-left-radius: 0px !important;
        }
        
        .hora-mensaje {
            font-size: 0.75rem;
            opacity: 0.8;
            display: block;
            text-align: right;
            margin-top: 5px;
        }
        .mensaje.mensaje-izquierda .hora-mensaje { color: #65676b; }
        .mensaje.mensaje-derecha .hora-mensaje { color: rgba(255, 255, 255, 0.8); }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .chat-wrapper {
                width: 100%;
                height: 100vh;
                margin: 0;
                border-radius: 0;
                border: none;
                flex-direction: column;
            }
            .container.izquierda {
                flex: 0 0 auto;
                max-height: 35vh;
                border-right: none !important;
                border-bottom: 1px solid black !important;
            }
            .container.derecha {
                flex: 1;
            }
             .chat-area header.nombreUsuario {
                margin-left: 0;
                margin-right: 0;
                border-radius: 0;
            }
            .typing-area {
                margin: 10px;
                border-radius: 30px; 
            }
        }

    </style>
</head>

<body>
    <?php include_once '../../components/navbar.php'; ?>

    <div class="chat-wrapper">
        <div class="container izquierda">
            <h3><i class="fas fa-comments"></i>Mis chats</h3>
            <div class="lista-chats">
                <?php
                $sql_lista_chats = $_conexion->prepare("
                    SELECT 
                        IF(m.id_mensaje_saliente = ?, m.id_mensaje_entrante, m.id_mensaje_saliente) AS otro_usuario_id,
                        MAX(m.fecha_envio) AS ultima_fecha,
                        (SELECT mensaje FROM mensajes 
                         WHERE (id_mensaje_saliente = ? AND id_mensaje_entrante = otro_usuario_id) 
                            OR (id_mensaje_saliente = otro_usuario_id AND id_mensaje_entrante = ?) 
                         ORDER BY fecha_envio DESC LIMIT 1) AS ultimo_mensaje_texto
                    FROM mensajes m
                    WHERE m.id_mensaje_saliente = ? OR m.id_mensaje_entrante = ?
                    GROUP BY otro_usuario_id
                    ORDER BY ultima_fecha DESC
                ");
                $sql_lista_chats->bind_param("sssss", $id_usuario_actual, $id_usuario_actual, $id_usuario_actual, $id_usuario_actual, $id_usuario_actual);
                $sql_lista_chats->execute();
                $resultado_lista_chats = $sql_lista_chats->get_result();

                if ($resultado_lista_chats->num_rows > 0) {
                    while ($fila_chat = $resultado_lista_chats->fetch_assoc()):
                        $id_otro_en_lista = $fila_chat["otro_usuario_id"];
                        $usuario_stmt = $_conexion->prepare("SELECT nombre, foto_perfil FROM usuario WHERE identificacion = ?");
                        $usuario_stmt->bind_param("s", $id_otro_en_lista);
                        $usuario_stmt->execute();
                        $usuario_data = $usuario_stmt->get_result()->fetch_assoc();

                        $nombre_lista = $usuario_data["nombre"] ?? "Usuario";
                        $foto_lista = !empty($usuario_data["foto_perfil"]) ? htmlspecialchars($usuario_data["foto_perfil"]) : '/src/img/perfil.png';
                        $mensaje_lista = htmlspecialchars($fila_chat["ultimo_mensaje_texto"]);
                        $hora_lista = date("H:i", strtotime($fila_chat["ultima_fecha"]));
                    ?>
                        <a href="conversa.php?chat_con=<?= urlencode($id_otro_en_lista) ?><?php if ($matricula_vehiculo) echo '&matricula=' . urlencode($matricula_vehiculo); ?>" class="chat-item">
                            <img src="<?= $foto_lista ?>" alt="Perfil de <?= htmlspecialchars($nombre_lista) ?>">
                            <div class="contenido-chat">
                                <span class="nombre"><?= htmlspecialchars($nombre_lista) ?></span>
                                <span class="mensaje"><?= $mensaje_lista ?></span>
                            </div>
                            <div class="hora"><?= $hora_lista ?></div>
                        </a>
                    <?php endwhile;
                } else { ?>
                    <div class="placeholder-no-chats">
                        <i class="fas fa-comment-slash fa-2x"></i>
                        <p>No tienes chats aún</p>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="container derecha">
            <section class="chat-area">
                <header class="nombreUsuario">
                    <a class="back-icon" href="/src/pages/rentacar/mostrar_coches">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <?php if ($id_chat_con_usuario): ?>
                        <div class="details">
                            <div class="usuario-estado">
                                <span class="nombre-usuario"><?= htmlspecialchars($nombre_en_cabecera) ?></span>
                                <span class="estado <?= $estado_en_cabecera === 'Online' ? 'online' : 'offline' ?>"></span>
                                <small><?= $estado_en_cabecera ?></small>
                            </div>
                            <?php if ($datos_coche_en_cabecera && ($id_chat_con_usuario === $id_propietario_coche || $matricula_vehiculo)): ?>
                                <p class="car-info"><?= htmlspecialchars(($datos_coche_en_cabecera["marca"] ?? "") . " " . ($datos_coche_en_cabecera["modelo"] ?? "")) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($matricula_vehiculo && $datos_coche_en_cabecera): ?>
                        <div class="details">
                            <div class="usuario-estado">
                                <span class="nombre-usuario">Propietario de <?= htmlspecialchars($datos_coche_en_cabecera['marca'] . " " . $datos_coche_en_cabecera['modelo']) ?></span>
                                <span class="estado <?= ($datos_coche_en_cabecera['propietario_estado'] == 1) ? 'online' : 'offline' ?>"></span>
                                <small><?= ($datos_coche_en_cabecera['propietario_estado'] == 1) ? 'Online' : 'Offline' ?></small>
                            </div>
                            <p><a href="conversa.php?chat_con=<?=urlencode($id_propietario_coche)?>&matricula=<?=urlencode($matricula_vehiculo)?>" style="color: var(--primary-color); text-decoration:underline;">Iniciar chat con <?=htmlspecialchars($datos_coche_en_cabecera['propietario_nombre'])?></a></p>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="chat-box" id="chat-container" data-id-saliente="<?= $id_usuario_actual ?>" data-id-entrante="<?= htmlspecialchars($id_chat_con_usuario ?? '') ?>">
                    <?php if (!$id_chat_con_usuario): ?>
                        <div class="empty-chat-placeholder">
                            <i class="fas fa-comment-dots"></i>
                            <h4>Selecciona un chat</h4>
                            <p>Elige una conversación para empezar a chatear</p>
                        </div>
                    <?php else:
                        $mensajes_sql = $_conexion->prepare("
                            SELECT * FROM mensajes 
                            WHERE (id_mensaje_saliente = ? AND id_mensaje_entrante = ?) 
                               OR (id_mensaje_saliente = ? AND id_mensaje_entrante = ?) 
                            ORDER BY fecha_envio ASC
                        ");
                        $mensajes_sql->bind_param("ssss", $id_usuario_actual, $id_chat_con_usuario, $id_chat_con_usuario, $id_usuario_actual);
                        $mensajes_sql->execute();
                        $mensajes_result = $mensajes_sql->get_result();

                        while ($mensaje_db = $mensajes_result->fetch_assoc()):
                            $esMio = $mensaje_db['id_mensaje_saliente'] == $id_usuario_actual;
                        ?>
                            <div class="mensaje-wrapper <?= $esMio ? 'mensaje-enviado' : 'mensaje-recibido' ?>">
                                <div class="mensaje <?= $esMio ? 'mensaje-derecha' : 'mensaje-izquierda' ?>">
                                    <p><?= htmlspecialchars($mensaje_db['mensaje']) ?></p>
                                    <span class="hora-mensaje"><?= date("H:i", strtotime($mensaje_db['fecha_envio'])) ?></span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>

                <?php if ($id_chat_con_usuario): ?>
                    <form class="typing-area" autocomplete="off" id="messageForm">
                        <textarea name="mensaje" class="input-field" id="mensajeInput" placeholder="Escribe un mensaje..." required></textarea>
                        <button type="submit" aria-label="Enviar mensaje">
                            <i class="fab fa-telegram-plane"></i>
                        </button>
                    </form>
                <?php else: ?>
                    <div class="select-chat-prompt">
                        <p>Selecciona un chat para empezar a conversar.</p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </div>

    <?php include_once '../../components/footer-example.php'; ?>

    <script src="../../js/conversa.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatContainer = document.getElementById('chat-container');
            if (chatContainer) {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
            
            const mensajeInput = document.getElementById('mensajeInput');
            if(mensajeInput) {
                function autoResizeTextarea() {
                    this.style.height = 'auto'; 
                    let newHeight = this.scrollHeight;
                    const maxHeight = 120; 

                    if (newHeight > maxHeight) {
                        newHeight = maxHeight;
                        this.style.overflowY = 'auto';
                    } else {
                        this.style.overflowY = 'hidden';
                    }
                    this.style.height = newHeight + 'px';
                }
                mensajeInput.addEventListener('input', autoResizeTextarea);
                autoResizeTextarea.call(mensajeInput);
            }
        });
    </script>

</body>
</html>