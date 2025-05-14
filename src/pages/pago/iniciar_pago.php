<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../../");
    exit();
}

if (!isset($_GET['tipo'])) {
    die("Solicitud inválida");
}

$tipo = $_GET['tipo'];

switch ($tipo) {
    case 'coche':
        if (!isset($_GET['precio_coche']) || !is_numeric($_GET['precio_coche'])) {
            die("Precio del coche inválido");
        }

        $precio_coche = floatval($_GET['precio_coche']);
        $_SESSION['precio_pago'] = $precio_coche;
        $_SESSION['concepto_pago'] = "Pago de Alquiler de coche";

        header("Location: paypal.php?page=");
        exit();
    case 'basica':
        $_SESSION['precio_pago'] = 9.99;
        $_SESSION['concepto_pago'] = "Pago de Suscripción Básica";
        // Redirige a PayPal
        header("Location: paypal.php?page=planes");
        exit();
    case 'premium':
        $_SESSION['precio_pago'] = 19.99;
        $_SESSION['concepto_pago'] = "Pago de Suscripción Premium";
        // Redirige a PayPal
        header("Location: paypal.php?page=planes");
        exit();
    default:
        die("Tipo de suscripción no válido");
}
?>