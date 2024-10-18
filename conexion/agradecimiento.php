

<?php
session_start();

// Verificar si la encuesta fue completada
if (!isset($_SESSION['encuesta_completada']) || $_SESSION['encuesta_completada'] !== true) {
    header("Location: ../index.php");
    exit();
}

// Destruir la sesión para evitar regresar a formularios anteriores
session_destroy();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar salida</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        video {
            position: fixed;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            transform: translate(-50%, -50%);
            background-size: cover;
        }
        header {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
            padding: 20px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.history && window.history.pushState) {
                window.history.pushState(null, null, window.location.href);
                window.onpopstate = function () {
                    window.location.href = '../index.php';
                };
            }
            setTimeout(function() {
                window.location.href = '../index.php';
            }, 3000);
        });
    </script>
</head>
<body>
    
    <video autoplay loop muted>
        <source src="../img/vd.mp4" type="video/mp4">
        Tu navegador no soporta la reproducción de videos.
    </video>
    <header>
        <h1>FORMULARIO COMPLETADO</h1>
    </header>
</body>
</html>

