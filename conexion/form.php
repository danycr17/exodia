<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar por Fecha</title>
    <link rel="stylesheet" href="../styles/styleForm.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                <div class="card-header alert text-white" style="background: #2ecc71; display: flex; align-items: center; justify-content: center;">

                        <h2 class="text-center mb-0">Consultar por Fecha</h2>
                    </div>
                    <div class="card-body">
                        <form action="consultas.php" method="POST">
                            <?php
                            include "../conexion/conexion.php";
                            session_start();
                            if (!isset($_SESSION['loggedin'])) {
                                header('Location: index.html');
                                exit;
                            }
                            function generarlista($conn) {
                                $sql = "SELECT * FROM `encuestas` WHERE estatus = 1";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo '<div class="mb-3">';
                                    echo '<label for="encuesta" class="form-label">Selecciona encuesta</label>';
                                    echo '<select id="encuesta" name="encuesta" class="form-select" required>';
                                    echo '<option value="" disabled selected >Selecciona encuesta</option>';
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="'  . $row['id_encuesta'] . '">' . $row['nombre'] . '</option>';
                                    }
                                    echo '</select>';
                                    echo '</div>';
                                } else {
                                    echo '<p class="text-danger">No hay encuestas disponibles.</p>';
                                }
                            }
                            generarlista($conn);
                            ?>
                            <div class="mb-3">
                                <label for="inicio_fecha" class="form-label">Fecha inicio</label>
                                <input type="date" id="inicio_fecha" name="inicio_fecha" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="final_fecha" class="form-label">Fecha final</label>
                                <input type="date" id="final_fecha" name="final_fecha" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit"  class="custom-button  btn-block ">Consultar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="result" class="container mt-5"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+CB9EXW9LtB5ptNkF0y6RWYpTw0QT" crossorigin="anonymous"></script>
</body>
</html>
