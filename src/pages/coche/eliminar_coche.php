<?php

// Redirigir si no hay sesión iniciada
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../../");
    exit();
}

require(__DIR__ . "/../../config/conexion.php");

if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    // Obtener la ruta de una imagen del coche
    $stmt_ruta = $_conexion->prepare("SELECT ruta_img_coche FROM imagen_coche WHERE id_coche = ? LIMIT 1");
    $stmt_ruta->bind_param("s", $matricula);
    $stmt_ruta->execute();
    $resultado_ruta = $stmt_ruta->get_result();

    $directorio_coche = null;

    if ($resultado_ruta->num_rows > 0) {
        $ruta_relativa = $resultado_ruta->fetch_assoc()['ruta_img_coche'];
        $directorio_coche = dirname($ruta_relativa);
    }

    $stmt_ruta->close();

    // Eliminar carpeta si existe
    if ($directorio_coche) {
        $ruta_absoluta = $_SERVER['DOCUMENT_ROOT'] . '/' . $directorio_coche;

        if (is_dir($ruta_absoluta)) {
            function eliminarDirectorio($ruta) {
                $archivos = array_diff(scandir($ruta), ['.', '..']);
                foreach ($archivos as $archivo) {
                    $ruta_completa = $ruta . '/' . $archivo;
                    if (is_dir($ruta_completa)) {
                        eliminarDirectorio($ruta_completa);
                    } else {
                        unlink($ruta_completa);
                    }
                }
                rmdir($ruta);
            }

            eliminarDirectorio($ruta_absoluta);
        }
    }

    // Eliminar el coche
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
