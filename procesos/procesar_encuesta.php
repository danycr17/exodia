<?php
include "../conexion/conexion.php";

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del usuario desde la URL
    $id_usuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;
    
    // Verificar que el ID del usuario sea válido
    if ($id_usuario <= 0) {
        die("ID de usuario inválido.");
    }

    // Preparar el SQL para insertar las respuestas
    $sql = "INSERT INTO respuestas (id_usuario, id_pregunta, respuesta) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Iterar sobre las respuestas del formulario
    foreach ($_POST as $key => $value) { 
        // Verificar si la clave comienza con 'respuesta_'
        if (strpos($key, 'respuesta_') === 0) {
            // Obtener el ID de la pregunta
            $id_pregunta = intval(substr($key, strlen('respuesta_')));
            
            // Verificar si la respuesta es un array (checkbox)
            if (is_array($value)) {
                foreach ($value as $respuesta) {
                    // Insertar cada respuesta en la base de datos
                    $stmt->bind_param("iis", $id_usuario, $id_pregunta, $respuesta);
                    if (!$stmt->execute()) {
                        echo "Error al guardar la respuesta: " . $stmt->error;
                    }
                }
            } else {
                // Insertar la respuesta en la base de datos
                $stmt->bind_param("iis", $id_usuario, $id_pregunta, $value);
                if (!$stmt->execute()) {
                    echo "Error al guardar la respuesta: " . $stmt->error;
                }
            }
        }
    }

    // Mensaje de éxito
    echo "Respuestas registradas correctamente.";
} else {
    // Mostrar un mensaje de error si no se ha enviado el formulario
    echo "No se ha enviado ningún formulario.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
