<?php
require(__DIR__ . "/../../config/conexion.php");
session_start();

$id_usuario = $_SESSION["usuario"]["identificacion"];
$otro_usuario = $_GET['chat_con'] ?? null;

if ($otro_usuario !== null && $id_usuario === $otro_usuario) {
    echo "No puedes enviarte mensajes a ti mismo.";
    exit();
}

$matricula = $_GET['matricula'] ?? null;

if ($matricula !== null) {
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
    $datos = null;
    $estado = "Offline";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SocialiCar - Chats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../../src/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include_once '../../components/links.php'; ?>
</head>
<body>
<?php include_once '../../components/navbar.php'; ?>

<div class="container py-5">
    <div class="card shadow-lg">
        <div class="row g-0">
            <!-- Lista de chats -->
            <div class="col-md-4 border-end">
                <div class="p-3 border-bottom text-white" style="background-color:#B0D5D9;"> <!--  #C4EEF2; -->
                    <h5 class="mb-0"><i class="fas fa-comments me-2"></i>Mis chats</h5>
                </div>
                <div class="p-0" style="background-color:rgb(255, 242, 242);">
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
                    ?>
                        <a href="conversa?chat_con=<?= urlencode($otro) ?>" class="d-flex align-items-center p-3 border-bottom text-decoration-none text-dark">
                            <img src="<?= htmlspecialchars($foto) ?>" alt="Perfil" class="rounded-circle me-3" width="50" height="50">
                            <div class="flex-grow-1">
                                <div class="fw-bold"><?= htmlspecialchars($nombre) ?></div>
                                <div class="text-muted small text-truncate"><?= $mensaje ?></div>
                            </div>
                            <div class="text-muted small ms-2"><?= $hora ?></div>
                        </a>
                    <?php endwhile; else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-comment-slash fa-2x mb-2 text-secondary"></i>
                            <p class="mb-0">No tienes chats aún</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Ventana de chat -->
            <div class="col-md-8 d-flex flex-column">
                <div class="border-bottom p-3 d-flex justify-content-between align-items-center bg-light">
                    <a class="btn btn-outline btn-sm" href="/src/pages/rentacar/mostrar_coches">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <?php if ($datos): ?>
                        <div>
                            <strong><?= htmlspecialchars($datos["nombre"]) ?></strong>
                            <span class="badge <?= $estado === 'Online' ? 'bg-success' : 'bg-secondary' ?>"><?= $estado ?></span>
                            <div class="text-muted small"><?= htmlspecialchars(($datos["marca"] ?? "") . " " . ($datos["modelo"] ?? "")) ?></div>
                        </div>
                    <?php elseif ($otro_usuario): ?>
                        <div>
                            <strong><?= htmlspecialchars($nombre ?? "Usuario") ?></strong>
                            <span class="badge bg-secondary">Offline</span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="flex-grow-1 overflow-auto p-3" id="chat-container" style="height: 400px;" data-id-saliente="<?= $id_usuario ?>" data-id-entrante="<?= htmlspecialchars($otro_usuario ?? '') ?>">
                    <?php if (!$otro_usuario): ?>
                        <div class="text-center my-5">
                            <i class="fas fa-comment-dots fa-3x mb-3 text-muted"></i>
                            <h4>Selecciona un chat</h4>
                            <p class="text-muted">Elige una conversación para empezar a chatear</p>
                        </div>
                    <?php else:
                        $mensajes_sql = $_conexion->prepare("
                            SELECT * FROM mensajes 
                            WHERE (id_mensaje_saliente = ? AND id_mensaje_entrante = ?) 
                               OR (id_mensaje_saliente = ? AND id_mensaje_entrante = ?) 
                            ORDER BY fecha_envio ASC
                        ");
                        $mensajes_sql->bind_param("ssss", $id_usuario, $otro_usuario, $otro_usuario, $id_usuario);
                        $mensajes_sql->execute();
                        $mensajes_result = $mensajes_sql->get_result();

                        while($mensaje = $mensajes_result->fetch_assoc()):
                            $esMio = $mensaje['id_mensaje_saliente'] == $id_usuario;
                    ?>
                        <div class="d-flex mb-2 <?= $esMio ? 'justify-content-end' : 'justify-content-start' ?>">
                            <div class="bg-<?= $esMio ? 'primary' : 'light' ?> text-<?= $esMio ? 'white' : 'dark' ?> p-2 rounded" style="max-width: 70%;">
                                <p class="mb-1"><?= htmlspecialchars($mensaje['mensaje']) ?></p>
                                <small class="text-muted"><?= date("H:i", strtotime($mensaje['fecha_envio'])) ?></small>
                            </div>
                        </div>
                    <?php endwhile; endif; ?>
                </div>

                <?php if ($otro_usuario): ?>
                    <div class="border-top p-3">
                        <form class="d-flex" autocomplete="off" id="messageForm">
                            <textarea name="mensaje" class="form-control me-2" id="mensajeInput" rows="1" placeholder="Escribe un mensaje..." required></textarea>
                            <button type="submit" class="btn btn-primary" aria-label="Enviar mensaje">
                                <i class="fab fa-telegram-plane"></i>
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="border-top p-3 text-center text-muted">
                        Selecciona un chat para empezar a conversar.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../components/footer-example.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Scroll automático al final del chat
    const chatContainer = document.getElementById('chat-container');
    if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
</script>
<script src="../../js/conversa.js"></script>
</body>
</html>
