<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Index</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="title-container text-center my-4">
        <h1>Seguridad POSCO Puebla</h1>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 button-container mb-4">
                <?php
                include "./conexion/conexion.php";

                function generarBotones($conn) {
                    $sql = "SELECT id_encuesta, nombre, url FROM encuestas WHERE id_encuesta != 4";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id_encuesta = $row["id_encuesta"];
                            $url = $row["url"];
                            // Crear la URL para redirigir a la presentación de Canva con el parámetro id_encuesta
                            $url_con_id = $url . "?id_encuesta=" . $id_encuesta;
                            echo '<a href="' . htmlspecialchars($url_con_id, ENT_QUOTES, 'UTF-8') . '" class="btn btn-success mb-4 btn-custom">' . htmlspecialchars($row["nombre"], ENT_QUOTES, 'UTF-8') . '</a><br>';
                        }
                    } else {
                        echo '<p>No hay resultados</p>';
                    }
                }

                // Generar los botones
                generarBotones($conn);

                // Cerrar la conexión
                $conn->close();
                ?>
            </div>
            <div class="col-md-6 image-container">
                <img src="img/posco1.PNG" class="img-fluid" alt="POSCO Puebla">
            </div>
        </div>
    </div>
</body>
</html>
