<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../../");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$env = parse_ini_file(__DIR__ . '/../../../.env');

if (!isset($env['EMAIL_USER'], $env['EMAIL_PASS'])) {
    die("Faltan variables en el archivo .env");
}

// Obtener y validar parámetros GET
if (!isset($_GET['correo'], $_GET['mensaje'], $_GET['asunto'])) {
    die("Faltan parámetros requeridos");
}

$correo = filter_var($_GET['correo'], FILTER_VALIDATE_EMAIL);
$correo_destino = "socialicar.rentacar@gmail.com";
$nombre = trim($_GET['nombre'] ?? '');
$telefono = trim($_GET['telefono'] ?? '');
$asunto = trim($_GET['asunto']);
$mensaje = trim($_GET['mensaje']);
$usuario = $_SESSION['usuario']['nombre'] ?? 'Usuario SocialiCar';

if (!$correo) {
    die("Correo inválido");
}

require __DIR__ . '/../../components/correo/PHPMailer.php';
require __DIR__ . '/../../components/correo/SMTP.php';
require __DIR__ . '/../../components/correo/Exception.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $env['EMAIL_USER'];
    $mail->Password   = $env['EMAIL_PASS'];
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom($env['EMAIL_USER'], $env['EMAIL_NAME'] ?? 'SocialiCar');
    $mail->addAddress($correo_destino, 'Equipo SocialiCar'); // Correo destino recibido por parámetro

    // Embedir imagen del logo
    $rutaImagen = __DIR__ . '/../../img/LogoSocialicar.png';
    $mail->addEmbeddedImage($rutaImagen, 'logo_socialicar', 'LogoSocialicar.png');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = htmlspecialchars($asunto);
    $mail->Body = '
    <div style="max-width:600px;margin:0 auto;font-family:Arial,sans-serif;color:#333;background:#f7f7f7;padding:20px;border-radius:8px;">
      <div style="text-align:center;margin-bottom:20px;">
        <img src="cid:logo_socialicar" alt="SocialiCar Logo" style="width:180px;height:auto;margin-bottom:20px;">
        <h2 style="color:#2c3e50;margin:0;">Nuevo mensaje desde el formulario de contacto</h2>
      </div>
      <div style="text-align:left;font-size:16px;line-height:1.6;">
        <p><strong>Nombre:</strong> ' . htmlspecialchars($nombre) . '</p>
        <p><strong>Email:</strong> ' . htmlspecialchars($correo) . '</p>
        <p><strong>Teléfono:</strong> ' . htmlspecialchars($telefono) . '</p>
        <p><strong>Asunto:</strong> ' . htmlspecialchars($asunto) . '</p>
        <p><strong>Mensaje:</strong><br>' . nl2br(htmlspecialchars($mensaje)) . '</p>
      </div>
      <hr style="margin:30px 0;border:none;border-top:1px solid #ddd;">
      <footer style="text-align:center;font-size:12px;color:#888;">
        Este mensaje fue enviado desde el formulario de contacto de SocialiCar.<br>
        © ' . date("Y") . ' SocialiCar. Todos los derechos reservados.
      </footer>
    </div>
    ';

    $mail->AltBody = "Nuevo mensaje de contacto:\n\nNombre: $nombre\nCorreo: $correo\nTeléfono: $telefono\nAsunto: $asunto\nMensaje:\n$mensaje";

    $mail->send();

    // Redirigir después de enviar
    header("Location: /src/pages/informacion/mensaje_enviado");
    exit();

} catch (Exception $e) {
    echo "❌ Error al enviar el mensaje: {$mail->ErrorInfo}";
}
