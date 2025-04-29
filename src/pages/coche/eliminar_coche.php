<?php
require(__DIR__ . "/../../config/conexion.php");

if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    $stmt = $_conexion->prepare("DELETE FROM coche WHERE matricula = ?");
    $stmt->bind_param("s", $matricula);

    if ($stmt->execute()) {
        header("Location: ../usuario/perfil_usuario.php");
        exit();
    } else {
        echo "Error al eliminar el coche: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Parámetro inválido.";
}

$_conexion->close();
?>