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
    <title>SocialiCar - Mis Chats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="../../../src/styles/chat.css">
    <?php include_once '../../components/links.php'; ?>
</head>
<body>
    <?php include_once '../../components/navbar.php'; ?>

    <div class="chat-wrapper">
        <div class="container izquierda">
            <h3>Mis chats</h3>
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
                    $foto = $usuario_data["foto_perfil"] ?? '../../../src/img/default-profile.png';
                    $mensaje = htmlspecialchars($fila["ultimo_mensaje"]);
                    $hora = date("H:i", strtotime($fila["ultima_fecha"]));
                ?>
                    <a href="chat.php?chat_con=<?= urlencode($otro) ?>" class="chat-item">
                        <img src="<?= $foto ?>" alt="Perfil">
                        <div class="contenido-chat">
                            <span class="nombre"><?= $nombre ?></span>  <!-- Muestra el nombre aquí -->
                            <span class="mensaje"><?= $mensaje ?></span>
                        </div>
                        <div class="hora"><?= $hora ?></div>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="container derecha">
            <section class="chat-area">
                <header>
                    <a class="back-icon" href="/src/pages/rentacar/mostrar_coches">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <?php if ($datos): ?>
                        <img src="<?= htmlspecialchars($datos["foto_perfil"] ?? '../../../src/img/default-profile.png') ?>" alt="Foto de perfil">
                        <div class="details">
                            <div class="usuario-estado">
                                <span class="nombre-usuario"><?= htmlspecialchars($datos["nombre"]) ?></span>  <!-- Muestra el nombre aquí -->
                                <span class="estado <?= $estado === 'Online' ? 'online' : 'offline' ?>"></span>
                            </div>
                            <p><?= htmlspecialchars(($datos["marca"] ?? "") . " " . ($datos["modelo"] ?? "")) ?></p>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="chat-box" id="chat-container" data-id-saliente="<?= $id_usuario ?>" data-id-entrante="<?= htmlspecialchars($otro_usuario ?? '') ?>">
                    <!-- Los mensajes se cargarán aquí -->
                </div>

                <?php if ($otro_usuario): ?>
                    <form class="typing-area" autocomplete="off" id="messageForm">
                        <input type="text" name="mensaje" class="input-field" id="mensajeInput" placeholder="Escribe un mensaje...">
                        <button type="submit"><i class="fab fa-telegram-plane"></i></button>
                    </form>
                <?php else: ?>
                    <p class="text-center p-3">Selecciona un chat para empezar a conversar.</p>
                <?php endif; ?>
            </section>
        </div>
    </div>

    <script src="../../js/chat.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
