<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página con video inicial</title>
    <style>
        /* Hacer que el video ocupe toda la pantalla */
        #video {
            width: 100%;
            height: 100vh;
            object-fit: cover;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Video inicial -->
    <video id="video" muted playsinline>
        <source src="/socialicar/src/video/video_inicial" type="video/mp4">
        Tu navegador no soporta el formato de video.
    </video>

    <script>
        // Obtén el elemento del video
        const video = document.getElementById('video');
        
        // Intenta reproducir el video manualmente si no se reproduce automáticamente
        video.play().catch(error => {
            console.log("Error al intentar reproducir el video:", error);
        });

        // Cuando el video termine, redirigimos a otra página
        video.onended = function() {
            window.location.href = "index2.php"; // Cambia esta URL por la que necesites
        };
    </script>

</body>
</html>
