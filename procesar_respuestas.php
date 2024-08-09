<?php
include "./conexion/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar los datos recibidos
    echo '<h3>Datos recibidos en $_POST:</h3>';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    
    if (isset($_POST['id_registro']) && isset($_POST['respuesta']) && is_array($_POST['respuesta'])) {
        $respuestas = $_POST['respuesta'];
        $id_registro = $conn->real_escape_string($_POST['id_registro']);
        $empresa = '';
        $nombre = '';

        // Debug: Imprimir id_registro recibido
        echo '<h3>ID Registro Recibido:</h3>';
        echo '<p>' .($id_registro) . '</p>';

        foreach ($respuestas as $id_pregunta => $respuesta) {
            $id_pregunta = (int)$id_pregunta;

            if (is_array($respuesta)) {
                $respuesta = implode(', ', array_map(array($conn, 'real_escape_string'), $respuesta));
            } else {
                $respuesta = $conn->real_escape_string($respuesta);
            }

            if ($id_pregunta) {
                $sql = "SELECT pregunta FROM preguntas WHERE id_pregunta = $id_pregunta";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $pregunta = $row["pregunta"];

                    // Debug: Imprimir pregunta y respuesta a insertar
                    echo '<h3>Pregunta:</h3>';
                    echo '<p>' .($pregunta) . '</p>';
                    echo '<h3>Respuesta:</h3>';
                    echo '<p>' .($respuesta) . '</p>';

                    $sql_insert_respuestas = "INSERT INTO respuestas (id_registro, id_pregunta, respuesta) VALUES ('$id_registro', '$id_pregunta', '$respuesta')";
                    
                    // Debug: Imprimir consulta SQL de inserción
                    echo '<h3>Consulta SQL de Inserción:</h3>';
                    echo '<p>' .($sql_insert_respuestas) . '</p>';

                    if (!$conn->query($sql_insert_respuestas)) {
                        echo "Error al guardar la respuesta: " . $conn->error;
                        exit;
                    }

                    if (strpos($pregunta, 'Empresa') !== false) {
                        $empresa = $respuesta;
                    } elseif (strpos($pregunta, 'Cual es tu nombre') !== false) {
                        $nombre = $respuesta;
                    }
                } else {
                    echo "Pregunta no encontrada para id_pregunta: $id_pregunta";
                }
            } else {
                echo "id_pregunta inválido: $id_pregunta";
            }
        }

        if ($empresa && $nombre) {
            $sql = "INSERT into reg_visit (empresa, nombre) Values ('$empresa', '$nombre')";
            
            echo '<h3>Consulta SQL de Actualización:</h3>';
            echo '<p>' .($sql) . '</p>';

            if ($conn->query($sql) === TRUE) {
                echo "Respuestas guardadas correctamente";
            } else {
                echo "Error al actualizar reg_visit: " . $conn->error;
            }
        } else {
            echo "Faltan algunas respuestas específicas. Asegúrate de completar todas las preguntas.";
        }
    } else {
        echo "No se recibieron respuestas válidas.";
    }

    exit;
}

$conn->close();
?>
