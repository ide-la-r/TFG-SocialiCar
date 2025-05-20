<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

require(__DIR__ . "/../../config/conexion.php");
require(__DIR__ . "/../../config/depurar.php");

// Verificar si la conexión está funcionando correctamente
if (!$_conexion) {
    echo "Error en la conexión a la base de datos.";
    exit();
}

// Redirigir si no hay sesión iniciada
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../../");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de usuario</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <script src="https://www.paypal.com/sdk/js?client-id=AacZbISDuTSpYnWbcg7nWx5DvHfRfVy-PEwgA1O63HkmtG6yhPnzY3tcCmm8iaU1dORsjBSJHXGH6159&currency=EUR"></script>
</head>
<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3a0ca3;
        --light-color: #f8f9fa;
        --dark-color: #212529;
    }
    
    body {
        background-image: url('../../img/fondo_perfil.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .payment-container {
        backdrop-filter: blur(5px);
        background-color: rgba(255, 255, 255, 0.85);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }
    
    .payment-header {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 1.5rem;
        text-align: center;
    }
    
    .payment-header .title {
        font-weight: 700;
        margin: 0;
        font-size: 1.8rem;
    }
    
    .payment-body {
        padding: 2rem;
    }
    
    .payment-summary {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .payment-summary p {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    
    .payment-summary strong {
        color: var(--secondary-color);
        font-weight: 600;
    }
    
    .payment-amount {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 1rem 0;
    }
    
    #paypal-button-conteiner {
        margin: 2rem 0;
    }
    
    .back-link {
        display: inline-block;
        margin-top: 1rem;
        color: var(--dark-color);
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .back-link:hover {
        color: var(--primary-color);
    }
    
    @media (max-width: 768px) {
        .payment-header .title {
            font-size: 1.5rem;
        }
        
        .payment-body {
            padding: 1.5rem;
        }
    }
</style>

<body>
    <?php include_once '../../components/navbar.php'; ?>
    <?php 
    $precio = $_SESSION['precio_pago'] ?? 0.0;
    $concepto = $_SESSION['concepto_pago'] ?? "Pago desconocido";
    ?>
    <?php $page = isset($_GET["page"]) ? $_GET["page"] : ""; ?>
    
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="payment-container">
                    <div class="payment-header">
                        <h1 class="title">Método de Pago</h1>
                    </div>
                    
                    <div class="card-body payment-body">
                        <div class="payment-summary">
                            <i class="fas fa-credit-card fa-3x mb-3" style="color: var(--primary-color);"></i>
                            <p><strong>Concepto:</strong> <?= htmlspecialchars($concepto) ?></p>
                            <div class="payment-amount"><?= number_format($precio, 2) ?>€</div>
                            <p class="text-muted">Pago seguro a través de PayPal</p>
                        </div>
                        
                        <div id="paypal-button-conteiner"></div>
                        
                        <div class="text-center">
                            <a href="<?= $page ? '../usuario/planes.php' : '../rentacar/mostrar_coches.php' ?>" class="back-link">
                                <i class="fas fa-arrow-left me-2"></i> Volver atrás
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const page = <?= json_encode($page) ?>;
        const concepto = <?= json_encode($concepto) ?>;
        const precio = <?= json_encode(number_format($precio, 2, '.', '')) ?>;

        paypal.Buttons({
            style:{
                color: 'blue',
                shape: 'pill',
                height: 45,
                label: 'pay'
            },
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units:[{
                        amount:{
                            value: precio
                        },
                        description: concepto
                    }] 
                });
            },
            onApprove: function(data, actions){
                actions.order.capture().then(function(detalles){
                    Swal.fire({
                        title: '¡Pago completado!',
                        text: 'Tu transacción se ha realizado con éxito.',
                        icon: 'success',
                        confirmButtonColor: 'var(--primary-color)'
                    }).then(() => {
                        if (page !== "") {
                            window.location.href = "../usuario/planes.php";
                        } else {
                            window.location.href = "../rentacar/mostrar_coches.php";
                        }
                    });
                });
            },
            onCancel: function(data){
                Swal.fire({
                    title: 'Pago cancelado',
                    text: 'No se ha completado el proceso de pago.',
                    icon: 'info',
                    confirmButtonColor: 'var(--primary-color)'
                }).then(() => {
                    if (page != ""){
                        window.location.href = "../usuario/planes.php";
                    } else{
                        window.location.href = "../rentacar/mostrar_coches.php";
                    }
                });
            },
            onError: function(err) {
                Swal.fire({
                    title: 'Error en el pago',
                    text: 'Ocurrió un error al procesar tu pago. Por favor, intenta nuevamente.',
                    icon: 'error',
                    confirmButtonColor: 'var(--primary-color)'
                });
            }
        }).render('#paypal-button-conteiner');
    </script>
    
    <?php include_once '../../components/footer-example.php'; ?>
</body>

</html>