<?php
include "./conexion/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Depuración: Imprimir datos recibidos
    echo '<h3>Datos recibidos en $_POST:</h3>';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    if (isset($_POST['id_registro']) && isset($_POST['empresa']) && isset($_POST['nombre'])) {
        $id_registro = $conn->real_escape_string($_POST['id_registro']);
        $empresa = $conn->real_escape_string($_POST['empresa']);
        $nombre = $conn->real_escape_string($_POST['nombre']);

        // Inserción en la tabla reg_visit
        $sql_insert = "INSERT INTO reg_visit (id_registro, empresa, nombre, fecha) VALUES ('$id_registro', '$empresa', '$nombre', current_timestamp())";

        if ($conn->query($sql_insert) === TRUE) {
            echo "Datos guardados correctamente.";
        } else {
            echo "Error al guardar los datos: " . $conn->error;
        }
    } else {
        echo "Faltan datos en el formulario.";
    }

    exit;
}

$conn->close();
?>
