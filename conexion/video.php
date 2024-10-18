<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Video</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background: linear-gradient(135deg, #f0f0f0, #d0d0d0);
      font-family: 'Arial', sans-serif;
      overflow: hidden;
    }

    .video-container {
      position: relative;
      width: 90%;
      max-width: 1000px;
      height: 80%;
      max-height: 1000px;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
      background: #000;
    }

    video {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .hidden {
      display: none;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
      font-size: 1.5em;
      font-weight: bold;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
      border-radius: 15px;
    }

    .button-container {
      position: absolute;
      top: 50%; /* Centrar verticalmente */
      left: 50%; /* Centrar horizontalmente */
      transform: translate(-50%, -50%); /* Ajustar posición para centrar completamente */
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 10; /* Asegurar que esté por encima del video */
    }

    #nextButton {
      background: linear-gradient(45deg, #28a745, #1e7e34);
      color: white;
      border: none;
      border-radius: 50px;
      padding: 15px 30px;
      font-size: 1.2em;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
      text-decoration: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      text-align: center;
      box-sizing: border-box;
    }

    #nextButton:hover {
      background: linear-gradient(45deg, #1e7e34, #28a745);
      transform: scale(1.05);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
    }

    #nextButton:focus {
      outline: none;
    }
  </style>
</head>
<body>

<?php
$id_encuesta = intval($_GET['id_encuesta']);

if ($id_encuesta == 3) {
  echo '<div class="button-container">'; // Mantener botón aquí
  echo '<button id="nextButton" class="hidden" onclick="window.location.href=\'https://www.canva.com/design/DAGQRpaM-iE/-uznjqCKYalKkVbY5RNsow/view?utm_content=DAGQRpaM-iE&utm_campaign=designshare&utm_medium=link&utm_source=editor\'">Siguiente</button>';
  echo '</div>';
} elseif ($id_encuesta == 1) {
  echo '<div class="button-container">';
  echo '<button id="nextButton" class="hidden" onclick="window.location.href=\'https://www.canva.com/design/DAGQTpCG-xs/CvxFM__XE6VYDOd9xOO_8A/view?utm_content=DAGQTpCG-xs&utm_campaign=designshare&utm_medium=link&utm_source=editor\'">Siguiente</button>';
  echo '</div>';
} else {
  echo '<div class="overlay">Encuesta no encontrada</div>';
}
?>

<div class="video-container">
  <video id="myVideo" autoplay muted>
    <source src="./img/SGA.mp4" type="video/mp4">
    Tu navegador no soporta la reproducción de videos.
  </video>
</div>

<script>
const video = document.getElementById('myVideo');
const nextButton = document.getElementById('nextButton');

// Aumentar la velocidad del video
video.playbackRate = 1.5;

// Mostrar el botón cuando el video termine
video.addEventListener('ended', () => {
  nextButton.classList.remove('hidden');
});
</script>

</body>
</html>
