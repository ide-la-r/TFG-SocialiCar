<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialiCar - Easter Egg</title>
    <?php include_once '../../components/links.php'; ?>
    <link rel="icon" href="../../../src/img/favicon.png" />
    <link rel="stylesheet" href="../../../src/styles/index.css">
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    require(__DIR__ . "/../../config/conexion.php");

    session_start();
    ?>
    <style>
        .yuri {
            width: 100%;
            height: auto;
            max-width: 600px;
            margin: 0 auto;
            display: block;
            animation-name: fatalDeLoSuyo;
            animation-duration: 1s;
            animation-iteration-count: infinite;
        }
        @keyframes fatalDeLoSuyo {
            0% {
            transform: translate3d(0, 0, 0) rotateY(0deg);
        }
        25% {
            transform: translate3d(30px, -50px, -100px) rotateY(15deg);
        }
        50% {
            transform: translate3d(-30px, 30px, -200px) rotateY(-15deg);
        }
        75% {
            transform: translate3d(10px, -20px, -100px) rotateY(10deg);
        }
        100% {
            transform: translate3d(0, 0, 0) rotateY(0deg);
        }
        }

        .yuri:hover {
            animation-name: duuuro;
            animation-duration: 0.03s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }
        @keyframes duuuro {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }


    </style>
</head>
<body>
    <?php include_once '../../components/navbar.php'; ?>

    <img class="yuri" src="../../img/yuri.png" alt="La yuri fatal de lo suyo :(">

    <?php include_once '../../components/footer-example.php'; ?>
</body>
</html>