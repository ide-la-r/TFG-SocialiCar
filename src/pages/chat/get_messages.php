<?php
require(__DIR__ . "/../../config/conexion.php"); // Conexión a la base de datos

$id_mensaje_entrante = $_GET['id_mensaje_entrante']; // Usuario receptor
$id_mensaje_saliente = $_GET['id_mensaje_saliente']; // Usuario emisor

$sql = "SELECT * FROM mensajes WHERE (id_mensaje_entrante = ? AND id_mensaje_saliente = ?) 
        OR (id_mensaje_entrante = ? AND id_mensaje_saliente = ?) 
        ORDER BY fecha_envio ASC";
$stmt = $_conexion->prepare($sql);
$stmt->bind_param("ssss", $id_mensaje_entrante, $id_mensaje_saliente, $id_mensaje_saliente, $id_mensaje_entrante);
$stmt->execute();
$result = $stmt->get_result();

// Iterar sobre los resultados y devolverlos en formato HTML
while ($row = $result->fetch_assoc()) {
    // Obtener el nombre del usuario que envió el mensaje
    $usuario_id = $row['id_mensaje_saliente'];
    $usuario_sql = "SELECT nombre FROM usuario WHERE identificacion = ?";
    $usuario_stmt = $_conexion->prepare($usuario_sql);
    $usuario_stmt->bind_param("s", $usuario_id);
    $usuario_stmt->execute();
    $usuario_result = $usuario_stmt->get_result();
    $usuario = $usuario_result->fetch_assoc();

    // Formatear la fecha para mostrar solo la hora
    $fecha_envio = new DateTime($row['fecha_envio']);
    $hora_formateada = $fecha_envio->format('H:i'); // Formato de hora: 00:00

    // Asignar una clase diferente para el emisor y el receptor
    $clase = ($row['id_mensaje_saliente'] == $id_mensaje_saliente) ? 'mensaje-emisor' : 'mensaje-receptor';

    // Mostrar el mensaje con la clase correspondiente
    if ($clase == 'mensaje-receptor') {
        // Mensajes recibidos (alineados a la izquierda)
        echo "<div class='$clase'>
                <div class='nombre-receptor'>{$usuario['nombre']}</div>
                <div class='mensaje-receptor'>{$row['mensaje']} <span class='hora-receptor'>{$hora_formateada}</span></div>
            </div>";
    } else {
        // Mensajes enviados (alineados a la derecha)
        echo "<div class='$clase'>
                <div class='nombre-emisor'>{$usuario['nombre']}</div>
                <div class='mensaje-emisor'>{$row['mensaje']} <span class='hora-emisor'>{$hora_formateada}</span></div>
            </div>";
    }
}
?>
