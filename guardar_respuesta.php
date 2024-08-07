<?php
include "./conexion/conexion.php";
include "funciones.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_registro = $_POST['id_registro'];
    $form_num = $_POST['form_num'];
    $pregunta_id = key(array_slice($_POST, 2, 1, true));
    $respuesta = $_POST[$pregunta_id];

    $sql = "INSERT INTO respuestas (id_registro, id_pregunta, respuesta, form_num) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE respuesta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissi", $id_registro, $pregunta_id, $respuesta, $form_num, $respuesta);

    if ($stmt->execute()) {
        echo "Respuesta guardada.";
    } else {
        echo "Error al guardar la respuesta.";
    }

    $stmt->close();
} else {
    echo "Método de solicitud no permitido.";
}
?>
