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
    <script src="https://www.paypal.com/sdk/js?client-id=ASaIpZ9AP6RkpKYB4dWGHafi71n5tEcfPp5LekIM9kW-kFcHlsrM36OD1kn6aOF2aHm8EboE_kHkSNn7&currency=EUR"></script>
</head>
<style>
    body {
        background-image: url('../../img/fondo_perfil.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        margin: 0;
    }
</style>

<body>
    <?php include_once '../../components/navbar.php'; ?>
    <?php $total_precio = floatval($_GET["total_precio"]); ?>
    <?php $page = isset($_GET["page"]) ? $_GET["page"] : ""; ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow rounded-4 p-4">
                    <div class="row g-4 mb-4">
                        <h1 class="title pt-4 text-center">Metodo de pago</h1>
                        <div id="paypal-button-conteiner"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const page = <?= json_encode($page) ?>;

        paypal.Buttons({
            style:{
                color: 'blue',
                shape: 'pill'
            },
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units:[{
                        amount:{
                            value: <?php echo $total_precio; ?>
                        }
                    }] 
                });
            },
            //hacer aqui todo lo de la base de datos cuando se efectue el pago
            onApprove: function(data, actions){
                actions.order.capture().then(function(detalles){
                    console.log(detalles);
                });
            },
            onCancel: function(data){
                alert("Compra cancelada");
                console.log("el valor de page es:", page)

                if (page != ""){
                    window.location.href = "../usuario/planes.php";
                } else{
                    window.location.href = "../rentacar/mostrar_coches.php";
                }
            }
        }).render('#paypal-button-conteiner')
    </script>
    <?php include_once '../../components/footer.php'; ?>
</body>

</html>