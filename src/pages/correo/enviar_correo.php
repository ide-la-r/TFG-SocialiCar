<?php

// Redirigir si no hay sesión iniciada
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../../");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar variables del .env
$env = parse_ini_file(__DIR__ . '/../../../.env');

// Incluir PHPMailer (ajustando la ruta)
require __DIR__ . '/../../components/correo/PHPMailer.php';
require __DIR__ . '/../../components/correo/SMTP.php';
require __DIR__ . '/../../components/correo/Exception.php';

$mail = new PHPMailer(true);

try {
    // Configuración SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $env['EMAIL_USER'];
    $mail->Password   = $env['EMAIL_PASS'];
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Destinatarios
    $mail->setFrom($env['EMAIL_USER'], $env['EMAIL_NAME']);
    $mail->addAddress($env['EMAIL_DEST'], 'Destinatario');

    // Contenido
    $mail->isHTML(true);
    $mail->Subject = 'Prueba de correo desde InfinityFree';
    $mail->Body    = 'Este es un mensaje de prueba <b>enviado con PHPMailer</b> desde InfinityFree.';
    $mail->AltBody = 'Este es un mensaje de prueba enviado con PHPMailer desde InfinityFree.';

    $mail->send();
    echo '✅ Mensaje enviado correctamente';
} catch (Exception $e) {
    echo "❌ Error al enviar el mensaje: {$mail->ErrorInfo}";
}