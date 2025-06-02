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

// Obtener correo y código desde parámetros GET
if (!isset($_GET['correo'], $_GET['codigo'])) {
    die("Faltan parámetros requeridos");
}

$correo = filter_var($_GET['correo'], FILTER_VALIDATE_EMAIL);
$codigo_verificacion = $_GET['codigo'];
$usuario = $_SESSION['usuario']['nombre'] ?? '';

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
    $mail->addAddress($correo); // Aquí el correo recibido por parámetro

    // Embedir la imagen local (ruta absoluta en servidor)
    $rutaImagen = __DIR__ . '/../../img/LogoSocialicar.png';
    $mail->addEmbeddedImage($rutaImagen, 'logo_socialicar', 'LogoSocialicar.png');

    $mail->isHTML(true);
    $mail->Subject = 'Verificación de correo electrónico';
    $mail->Body = '
    <div style="max-width:600px;margin:0 auto;font-family:Arial, sans-serif;color:#333;">
      <div style="background:#f7f7f7;padding:20px;text-align:center;border-radius:8px;">
        <img src="cid:logo_socialicar" alt="SocialiCar Logo" style="display:block; margin:0 auto 20px auto; width:200px; height:auto;">
        <h2 style="color:#2c3e50;">Verificación de correo electrónico</h2>
        <p>Hola, '.$usuario.'</p>
        <p>Gracias por registrarte en <strong>SocialiCar</strong>.</p>
        <p>Para completar tu registro, por favor utiliza el siguiente código de verificación:</p>
        <div style="margin:30px 0;">
          <span style="
            display:inline-block;
            padding:15px 30px;
            font-size:28px;
            font-weight:bold;
            letter-spacing:5px;
            background:#6dbec8;
            color:#fff;
            border-radius:6px;
            box-shadow:0 4px 6px rgba(0,0,0,0.1);
            user-select:none;
          ">'.$codigo_verificacion.'</span>
        </div>
        <p style="font-size:14px;color:#777;">Si no solicitaste este código, ignora este mensaje.</p>
        <hr style="border:none;border-top:1px solid #ddd;margin:30px 0;">
        <p style="font-size:12px;color:#aaa;">© '.date("Y").' SocialiCar. Todos los derechos reservados.</p>
      </div>
    </div>
    ';
    $mail->AltBody = 'Tu código de verificación en SocialiCar es: '.$codigo_verificacion;

    $mail->send();

    // Redirigir a validar usuario después de enviar el correo
    header("Location: /src/pages/usuario/validar_usuario");
    exit();

} catch (Exception $e) {
    echo "❌ Error al enviar el mensaje: {$mail->ErrorInfo}";
}
