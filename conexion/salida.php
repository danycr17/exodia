<?php
session_start();

if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    // Eliminar el mensaje de la sesión para evitar que se muestre nuevamente
    unset($_SESSION['mensaje']);
    
    // Imprimir el token de sesión antes de destruir la sesión
    if (isset($_SESSION['token'])) {
        $token = $_SESSION['token'];
    } else {
        $token = "Token no encontrado.";
    }
    
} else {
    // Si no hay mensaje, redirigir al formulario para evitar accesos directos a salida.php
    header("Location: formulario.php");
    exit();
}

// Destruir todas las variables de sesión después de obtener el token
session_unset();
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
                    window.location.href = 'index.php';
                };
            }
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 3000);
        });
    </script>
</head>
<body>
    
    <video autoplay loop muted>
        <source src="./img/vd.mp4" type="video/mp4">
        Tu navegador no soporta la reproducción de videos.
    </video>
    <header>
        <h1>FORMULARIO COMPLETADO</h1>
        <p><?php echo $mensaje; ?></p>
        <p>Token de sesión: <?php echo htmlspecialchars($token); ?></p>
    </header>
</body>
</html>
