<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Páginaa Web</title>
    <link rel="stylesheet" href="./styles/styleForm.css">
   

</head>
<body>
     

<?php
include "./conexion/conexion.php";

// Función para generar el formulario de registro dinámicamente
function generarFormularioRegistro($conn) {
    // Obtener preguntas de registro
    $sql = "SELECT * FROM preguntas_registro";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<form action="" method="post">';
        echo '<table class="table table-bordered">';
        echo '<thead><tr><th>Pregunta</th><th>Respuesta</th></tr></thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['pregunta'], ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>';
            switch ($row['tipo_pregunta']) {
                case 'text':
                    echo '<input type="text" class="form-control" id="pregunta_' . $row['id_pregunta'] . '" name="respuesta_' . $row['id_pregunta'] . '" required>';
                    break;

                case 'lista':
                    echo '<select class="form-select" id="pregunta_' . $row['id_pregunta'] . '" name="respuesta_' . $row['id_pregunta'] . '" required>';
                    // Obtener las opciones de la tabla pregunta_detalle basado en el grupo
                    $opciones_sql = "SELECT nombre FROM pregunta_detalle WHERE grupo='" . $conn->real_escape_string($row['conf']) . "'";
                    $opciones_result = $conn->query($opciones_sql);
                    if ($opciones_result->num_rows > 0) {
                        while ($opcion = $opciones_result->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($opcion['nombre'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($opcion['nombre'], ENT_QUOTES, 'UTF-8') . '</option>';
                        }
                    }
                    echo '</select>';
                    break;
            }
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '<button type="submit" class="btn btn-primary">Registrar</button>';
        echo '</form>';
    } else {
        echo '<p>No hay preguntas de registro disponibles.</p>';
    }
}

// Función para generar el formulario de encuesta dinámicamente
function generarFormularioEncuesta($conn, $id_encuesta) {
    // Obtener el título de la encuesta
    $titulo_sql = "SELECT nombre FROM encuestas WHERE id_encuesta = ?";
    $stmt = $conn->prepare($titulo_sql);
    $stmt->bind_param("i", $id_encuesta);
    $stmt->execute();
    $titulo_result = $stmt->get_result();
    $titulo = $titulo_result->fetch_assoc();

    // Mostrar el título de la encuesta
    if ($titulo) {
        echo '<h2>' . htmlspecialchars($titulo['nombre'], ENT_QUOTES, 'UTF-8') . '</h2>';
    } else {
        echo '<h2>Encuesta no encontrada</h2>';
    }

    // Obtener preguntas de la encuesta
    $sql = "SELECT * FROM preguntas WHERE id_encuesta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_encuesta);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<form action="./procesos/procesar_encuesta.php?id_usuario=' . $_GET['id_usuario'] . '" method="post">';
        echo '<table class="table table-bordered">';
        echo '<thead><tr><th>Pregunta</th><th>Respuesta</th></tr></thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['pregunta'], ENT_QUOTES, 'UTF-8') . '</td>';
            echo '<td>';
            switch ($row['tipo_pregunta']) {
                case 'text':
                    echo '<input type="text" class="form-control" id="pregunta_' . $row['id_pregunta'] . '" name="respuesta_' . $row['id_pregunta'] . '" required>';
                    break;

                case 'lista':
                    echo '<select class="form-select" id="pregunta_' . $row['id_pregunta'] . '" name="respuesta_' . $row['id_pregunta'] . '" required>';
                    $opciones_sql = "SELECT nombre FROM pregunta_detalle WHERE grupo='" . $conn->real_escape_string($row['conf']) . "'";
                    $opciones_result = $conn->query($opciones_sql);
                    if ($opciones_result->num_rows > 0) {
                        while ($opcion = $opciones_result->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($opcion['nombre'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($opcion['nombre'], ENT_QUOTES, 'UTF-8') . '</option>';
                        }
                    }
                    echo '</select>';
                    break;

                case 'checkbox':
                    $opciones_sql = "SELECT nombre FROM pregunta_detalle WHERE grupo='" . $conn->real_escape_string($row['conf']) . "'";
                    $opciones_result = $conn->query($opciones_sql);
                    if ($opciones_result->num_rows > 0) {
                        while ($opcion = $opciones_result->fetch_assoc()) {
                            echo '<div><input type="checkbox" id="pregunta_' . $row['id_pregunta'] . '_' . htmlspecialchars($opcion['nombre'], ENT_QUOTES, 'UTF-8') . '" name="respuesta_' . $row['id_pregunta'] . '[]" value="' . htmlspecialchars($opcion['nombre'], ENT_QUOTES, 'UTF-8') . '"> ' . htmlspecialchars($opcion['nombre'], ENT_QUOTES, 'UTF-8') . '</div>';
                        }
                    }
                    break;

                case 'radio':
                    $opciones_sql = "SELECT nombre FROM pregunta_detalle WHERE grupo='" . $conn->real_escape_string($row['conf']) . "'";
                    $opciones_result = $conn->query($opciones_sql);
                    if ($opciones_result->num_rows > 0) {
                        while ($opcion = $opciones_result->fetch_assoc()) {
                            echo '<div><input type="radio" id="pregunta_' . $row['id_pregunta'] . '_' . htmlspecialchars($opcion['nombre'], ENT_QUOTES, 'UTF-8') . '" name="respuesta_' . $row['id_pregunta'] . '" value="' . htmlspecialchars($opcion['nombre'], ENT_QUOTES, 'UTF-8') . '"> ' . htmlspecialchars($opcion['nombre'], ENT_QUOTES, 'UTF-8') . '</div>';
                        }
                    }
                    break;
            }
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '<button type="submit" class="btn btn-primary">Enviar</button>';
        echo '</form>';
    } else {
        echo '<p>No hay preguntas disponibles para esta encuesta.</p>';
    }
}

// Manejo del formulario enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['respuesta_1'])) {
        // Procesar el formulario de registro
        $empresa = $_POST['respuesta_1'];
        $nombre_completo = $_POST['respuesta_2'];
        $area = $_POST['respuesta_3'];

        $sql = "INSERT INTO usuarios_registro (empresa, nombre_completo, area) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $empresa, $nombre_completo, $area);

        if ($stmt->execute()) {
            // Obtener el ID del usuario insertado
            $id_usuario = $stmt->insert_id;
            // Obtener el id_encuesta de la URL original
            $id_encuesta = intval($_GET['id_encuesta']);
            // Redirigir para mostrar el formulario de encuesta correspondiente
            header("Location: ".$_SERVER['PHP_SELF']."?id_usuario=$id_usuario&id_encuesta=$id_encuesta");
            exit();
        } else {
            echo "Error al registrar los datos: " . $conn->error;
        }
    } elseif (isset($_POST['respuesta_'])) {
        // Procesar respuestas del formulario de encuesta
        $id_usuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;

        foreach ($_POST as $key => $value) {
            if (strpos($key, 'respuesta_') === 0) {
                $id_pregunta = intval(substr($key, 10));
                $respuesta = is_array($value) ? implode(", ", $value) : $value;

                $sql = "INSERT INTO respuestas (id_usuario, id_pregunta, respuesta) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iis", $id_usuario, $id_pregunta, $respuesta);

                if (!$stmt->execute()) {
                    echo "Error al guardar la respuesta: " . $conn->error;
                }
            }
        }

        echo "Respuestas guardadas correctamente.";
    }
}

else {
    if (isset($_GET['id_usuario']) && isset($_GET['id_encuesta'])) {
        // Mostrar formulario de encuesta
        $id_encuesta = intval($_GET['id_encuesta']);
        generarFormularioEncuesta($conn, $id_encuesta);
    } else {
        // Mostrar formulario de registro
        generarFormularioRegistro($conn);
    }
}

$conn->close();
?>


</body>
</html>
