<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Index</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="title-container">
        <h1>Seguridad POSCO </h1>
    </div>

    <div class="container">
       <div class="button-container">
     
            <?php
            include "./conexion/conexion.php";

            function generarBotones($conn) {
                $sql = "SELECT id_encuesta, nombre, url FROM form";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $url = $row["url"]; // Obtén la URL desde la base de datos
                        echo '<button onclick="window.location.href=\'' . $url . '\'">' . htmlspecialchars($row["nombre"], ENT_QUOTES, 'UTF-8') . '</button>';
                    }
                } else {
                    echo "No hay resultados";
                }
               
            }

            // Generar los botones
            generarBotones($conn);
          
          

            // Cerrar la conexión
            $conn->close();
            ?>

      <a href=" form.php?id_encuesta=4"> <button type="button">Prueba</button></a>


        </div>
        <div class="image-container">
            <img src="img/posco1.PNG" style="max-width: 100%;">
        </div>
    </div>
    
</body>
</html>
