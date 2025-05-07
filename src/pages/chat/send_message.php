<?php
require(__DIR__ . "/../../config/conexion.php"); // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Asegúrate de que estos valores provienen del frontend correctamente
    $mensaje = $_POST['mensaje'];
    $id_mensaje_entrante = $_POST['id_mensaje_entrante']; // Usuario receptor
    $id_mensaje_saliente = $_POST['id_mensaje_saliente']; // Usuario que envía

    // Consulta SQL para guardar el mensaje en la base de datos
    $sql = "INSERT INTO mensajes (id_mensaje_entrante, id_mensaje_saliente, mensaje) VALUES (?, ?, ?)";
    $stmt = $_conexion->prepare($sql);
    $stmt->bind_param("sss", $id_mensaje_entrante, $id_mensaje_saliente, $mensaje);
    
    if ($stmt->execute()) {
        echo "Mensaje enviado con éxito"; // Respuesta de confirmación
    } else {
        echo "Error al enviar el mensaje: " . $stmt->error; // Mostrar error si no se pudo insertar
    }
}
?>