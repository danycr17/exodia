<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formu</title>
    <link rel="stylesheet" href="./styles/styleForm.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

 </head>
<body></body>

<?php
session_start();

include "./conexion/conexion.php";

$id_encuesta = isset($_GET['ec']) ? intval($_GET['ec']) : 0;
function generarFormularioRegistro($conn, $id_usuario, $id_encuesta) {
 
    $sql = "SELECT * FROM preguntas_registro";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<form method="POST" action="">'; 
        echo '<input type="hidden" name="id_usuario" value="' . ($id_usuario) . '">';
        echo '<input type="hidden" name="id_encuesta" value="' . ($id_encuesta) . '">';

        echo '<table>';
        echo '<thead><tr><th>Pregunta</th><th>Respuesta</th></thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . ($row['pregunta']) . '</td>';
            echo '<td>';

            switch ($row['tipo_pregunta']) {
                case 'text':
                    echo '<input type="text" class="form-control" id="pregunta_' . $row['id_pregunta'] . '" name="respuesta_' . $row['id_pregunta'] . '" required>';
                    break;

                case 'lista':
                    echo '<select class="form-select" id="pregunta_' . $row['id_pregunta'] . '" name="respuesta_' . $row['id_pregunta'] . '" required>';
                    $opciones_sql = "SELECT nombre FROM pregunta_detalle WHERE  grupo='"  . $conn->real_escape_string($row['conf']) . "' order by nombre ";
                    $opciones_result = $conn->query($opciones_sql);
                    if ($opciones_result->num_rows > 0) {
                        while ($opcion = $opciones_result->fetch_assoc()) {
                            echo '<option value="' . ($opcion['nombre']) . '">' . ($opcion['nombre']) . '</option>';
                        }
                    }
                    echo '</select>';
                    break;


                case 'checkbox':
                    $opciones_sql = "SELECT nombre FROM pregunta_detalle WHERE grupo='" . $conn->real_escape_string($row['conf']) . "'";
                    $opciones_result = $conn->query($opciones_sql);
                    if ($opciones_result->num_rows > 0) {
                        while ($opcion = $opciones_result->fetch_assoc()) {
                            echo '<div><input type="checkbox" class="form-control" id="pregunta_' . $row['id_pregunta'] . '_' . ($opcion['nombre']) . '" name="respuesta_' . $row['id_pregunta'] . '[]" value="' . ($opcion['nombre']) . '"> ' . ($opcion['nombre']) . '</div>';
                        }
                    }
                    break;

                case 'radio':
                    $opciones_sql = "SELECT nombre FROM pregunta_detalle WHERE grupo='" . $conn->real_escape_string($row['conf']) . "'";
                    $opciones_result = $conn->query($opciones_sql);
                    if ($opciones_result->num_rows > 0) {
                        while ($opcion = $opciones_result->fetch_assoc()) {
                            echo '<div><input type="radio" class="form-control" id="pregunta_' . $row['id_pregunta'] . '_' . ($opcion['nombre']) . '" name="respuesta_' . $row['id_pregunta'] . '" value="' . ($opcion['nombre']) . '" required> ' . ($opcion['nombre']) . '</div>';
                        }
                    }
                    break;
            }
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '<button type="submit" class="custom-button" id="submitButton">Enviar</button>';
        echo '</form>';
    } else {
        echo '<p>No hay preguntas de encuesta disponibles.</p>';
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['respuesta_1']) && isset($_POST['respuesta_2']) && isset($_POST['respuesta_3'])) {
  

        $empresa = $_POST['respuesta_1'];
        $nombre_completo = $_POST['respuesta_2'];
        $area = $_POST['respuesta_3'];

        // Verificar que el id_encuesta existe
        $verificar_sql = "SELECT * FROM encuestas WHERE id_encuesta = ?";
        $verificar_stmt = $conn->prepare($verificar_sql);
        $verificar_stmt->bind_param("i", $id_encuesta);
        $verificar_stmt->execute();
        $verificar_result = $verificar_stmt->get_result();

        if ($verificar_result->num_rows > 0) {
            // Proceder a insertar

             $estado = 1 ;

            $sql = "INSERT INTO usuarios_registro (empresa, nombre_completo, area, id_enc, estado) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssii", $empresa, $nombre_completo, $area, $id_encuesta, $estado);

            if ($stmt->execute()) {
                // Obtener el ID del usuario insertado
                $id_usuario = $stmt->insert_id;

                // Guardar en la sesión
                $_SESSION['id_usuario'] = $id_usuario;
                $_SESSION['id_encuesta'] = $id_encuesta;

                // Redirigir al formulario de encuesta
                header("Location: formulario_encuesta.php");
                exit();
            } else {
                echo "Error al registrar los datos: " . $stmt->error;
            }
        } else {
            echo "El ID de la encuesta no existe.";
        }
    }
} else {
    
 
    $id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '';

    generarFormularioRegistro($conn, $id_usuario, $id_encuesta);
    
}

$conn->close();
?>

<script>
 document.addEventListener('DOMContentLoaded', function() {
            // Desplazar hacia arriba si hay mensajes de error
            var errorMessages = document.querySelectorAll('.error');
            if (errorMessages.length > 0) {
                window.scrollTo(0, 0);
            }

            // Verificar los campos del formulario
            var inputs = document.querySelectorAll('input[type="text"], select, input[type="radio"], input[type="checkbox"]');
            var submitButton = document.getElementById('submitButton');

            function checkInputs() {
                var allFilled = true;

                inputs.forEach(function(input) {
                    if (input.type === 'radio' || input.type === 'checkbox') {
                        var name = input.name;
                        var checked = document.querySelector('input[name="' + name + '"]:checked');
                        if (!checked) {
                            allFilled = false;
                        }
                    } else if (input.type === 'text') {
                        if (input.value.trim() === '') {
                            allFilled = false;
                        }
                    } else if (input.tagName.toLowerCase() === 'select') {
                        if (input.value === '') {
                            allFilled = false;
                        }
                    }
                });

                submitButton.disabled = !allFilled;
            }

            inputs.forEach(function(input) {
                input.addEventListener('input', checkInputs);
                input.addEventListener('change', checkInputs); // Para radio y checkbox
            });
            checkInputs();

            // Deshabilitar el botón de envío al enviar el formulario
            document.getElementById('surveyForm').addEventListener('submit', function(event) {
                var submitButton = event.target.querySelector('button[type="submit"]');
                submitButton.disabled = true;

                // Deshabilitar toda la página
                document.body.innerHTML = '<h1>Gracias por su participación</h1>';
                document.body.style.pointerEvents = 'none';

              
                
            });
        });
</script>