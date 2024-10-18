<?php
session_start(); 

if (isset($_SESSION['token'])) {
 
    unset($_SESSION['token']); 
    session_destroy();
    session_start();
    $token = "Token destruido. Nueva sesión iniciada.";
} else {
    $token = "Token no encontrado.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/styles.css">
</head>
<body>
    

<div class="row">
    <div class="col-md-4 col-sm-4"></div>
        <div class="col-md-4 col-sm-4 title-container text-center my-4">
        <h1>Seguridad POSCO Puebla</h1>
        </>
    <div class="col-md-4"></div>
</div>

<?php  

include "./conexion/conexion.php";

echo '<div class="container">';

function generarBotones($conn) {
    $sql = "
        SELECT id_encuesta, nombre, estatus, url 
        FROM menu  
        WHERE id_encuesta != 4 AND estatus = 1;
    ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="row">';
        echo '<div class="col-md-6">';
        while ($row = $result->fetch_assoc()) {
            $id_encuesta = $row["id_encuesta"];
            $url = $row["url"];
            $url_con_id = $url . "?id_encuesta=" . $id_encuesta;

              
            echo'<br>';
            echo '<div class="button-container mb-2">';

            echo '<a href="' . $url_con_id . '" class="btn btn-success mb-6 btn-custom">' . $row["nombre"] . '</a><br>';
            echo '</div>';
        }
        echo '</div>';
        echo '<div class="col-md-4 image-container">';
        echo '<img src="img/posco1.PNG" class="img-fluid" alt="POSCO Puebla">';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p>No hay resultados</p>';
    }
}

generarBotones($conn);
$conn->close();

echo '</div>';
?>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.history && window.history.pushState) {
                // Crear un estado ficticio en la historia del navegador
                window.history.pushState(null, null, window.location.href);
                
               
            }
        });
    </script>
</body>
</html>
