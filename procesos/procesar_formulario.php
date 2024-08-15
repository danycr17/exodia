<?php
include "../conexion/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_registro = $_POST['id_registro'];
    $respuestas = $_POST['respuesta'];

    foreach ($respuestas as $id_pregunta => $respuesta) {
        if (is_array($respuesta)) {
            $respuesta = implode(',', $respuesta); // Para manejar checkbox
        }
        $sql = "INSERT INTO respuestas (id_registro, id_pregunta, respuesta) VALUES ('$id_registro', '$id_pregunta', '$respuesta')";
        if ($conn->query($sql) === TRUE) {
            echo "Respuesta guardada correctamente";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
$conn->close();
?>
