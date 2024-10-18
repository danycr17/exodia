<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="./styles/styleForm.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body></body>

<?php

include "./conexion/conexion.php";

session_start();
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['id_encuesta'])) {
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['encuesta_completada']) && $_SESSION['encuesta_completada'] === true) {
    die("Ya has completado esta encuesta.");
}
 $id_usuario = $_SESSION['id_usuario'];
 $id_encuesta = $_SESSION['id_encuesta'];

 
 generarFormularioEncuestas($conn, $id_encuesta, $id_usuario);
 
 function generarFormularioEncuestas($conn, $id_encuesta, $id_usuario) {
    global $token;
    $sql = "SELECT * FROM preguntas WHERE id_encuesta = ? ORDER BY preguntas.orden ASC";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . ($conn->error));
    }

    $stmt->bind_param("i", $id_encuesta);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $preguntas_array = [];

    while ($row = $result->fetch_assoc()) {
        $preguntas_array[] = $row;
    }
    
    if (!empty($preguntas_array)) {
        echo '<form id="formularioEncuesta" action="./procesos/procesar_encuesta.php" method="post">';
        
        echo '<style>';
        echo '@media (max-width: 765px) {';
        echo '  .table-row { display: flex; flex-direction: column; }';
        echo '}';
        echo '</style>';
        echo '<div class="container border border-primary-subtle bg-light-subtle p-4 align-items-center">';

        foreach ($preguntas_array as $row) {
            switch ($row['tipo_pregunta']) {
                case 'titulo':
                    echo '<div class="row"><div class="encuesta-titulo text-center ">' . $row['pregunta'] . '</div></div>';
                    break;

                case 'text':
                    echo '<div class="row alert alert-info border border-success" style="background: #93ffb3;">';
                    echo '<div class="col-sm-8 col-md-12">' . $row['pregunta'] . '</div>';
                    echo '<div class="col-sm-12 col-md-"> <input type="text" class="form-control" id="pregunta_' . $row['id_pregunta'] . '" name="respuesta_' . $row['id_pregunta'] . '" required></div>';
                    echo '</div>';
                    break;

                case 'lista':
                    echo '<div  class="row alert alert-info"  style="background: #93ffb3">';
                    echo '<div class="col-sm-8  col-md-6">' . $row['pregunta'] . '</div>';
                    echo '<div class="col-sm-12 col-md-6 "><select class="form-select" id="pregunta_' . $row['id_pregunta'] . '" name="respuesta_' . $row['id_pregunta'] . '" required>';
                  
                    $opciones_sql = "SELECT nombre FROM pregunta_detalle WHERE grupo='" . $conn->real_escape_string($row['conf']) . "'";
                    $opciones_result = $conn->query($opciones_sql);
                    if ($opciones_result->num_rows > 0) {
                        while ($opcion = $opciones_result->fetch_assoc()) {
                            echo '<option value="' . $opcion['nombre'] . '">' . $opcion['nombre'] . '</option>';
                        }
                    }
                    echo '</select></div>';
                    echo '</div>';
                    break;
                    
                    case 'checkbox':
                        echo '<div class="row">';
                        echo '<div class="col-sm-12  border border-success col-md-6 alert" style="background: #93ffb3; d-flex align-items-center;">' . $row['pregunta'] . '</div>';
                        echo '<div class="col-sm-12    border border-success col-md-6 alert alert-light">';
                        $opciones_sql = "SELECT nombre FROM pregunta_detalle WHERE grupo='" . $conn->real_escape_string($row['conf']) . "'";
                        $opciones_result = $conn->query($opciones_sql);
                        if ($opciones_result->num_rows > 0) {
                            while ($opcion = $opciones_result->fetch_assoc()) {
                                echo '<div class="col-sm-6 col-md-4 form-check">';
                                echo '<input class="form-check-input" type="checkbox" id="pregunta_' . $row['id_pregunta'] . '_' . $opcion['nombre'] . '" name="respuesta_' . $row['id_pregunta'] . '[]" value="' . $opcion['nombre'] . '">';
                                echo '<label class="form-check-label" for="pregunta_' . $row['id_pregunta'] . '_' . $opcion['nombre'] . '">' . $opcion['nombre'] . '</label>';
                                echo '</div>';
                            }
                        }
                        echo '</div>';
                        echo '</div>';
                        break;
                    
                    
                        case 'radio':
                            echo '<div class="row" >';
                          echo '<div class="col-sm-12   border border-success col-md-6 alert" style="background: #93ffb3; d-flex align-items-center;">'. $row['pregunta'] . '</div>';
                            echo '<div class="col-sm-12 border border-success  col-md-6 alert alert-light">';
                            $opciones_sql = "SELECT nombre FROM pregunta_detalle WHERE grupo='" . $conn->real_escape_string($row['conf']) . "'";
                            $opciones_result = $conn->query($opciones_sql);
                            if ($opciones_result->num_rows > 0) {
                                while ($opcion = $opciones_result->fetch_assoc()) {
                                    echo '<div class="col-sm-6   col-md-4 form-check">';
                                    echo '<input class="form-check-input" type="radio" id="pregunta_' . $row['id_pregunta'] . '_' . $opcion['nombre'] . '" name="respuesta_' . $row['id_pregunta'] . '" value="' . $opcion['nombre'] . '" required>';
                                    echo '<label class="form-check-label" for="pregunta_' . $row['id_pregunta'] . '_' . $opcion['nombre'] . '">' . $opcion['nombre'] . '</label>';
                                    echo '</div>';
                                }
                            }
                            echo '</div>';
                            echo '</div>';
                            break;
                            

                            case 'radio2':
                                echo '<div class="row" >'; 
                                echo '<div class="border border-success col-sm-12 col-md-12 alert" style="background: #93ffb3;">' . $row['pregunta'];
                                $opciones_sql = "SELECT nombre FROM pregunta_detalle WHERE grupo='" . $conn->real_escape_string($row['conf']) . "'";
                                $opciones_result = $conn->query($opciones_sql);
                                if ($opciones_result->num_rows > 0) {
                                    while ($opcion = $opciones_result->fetch_assoc()) {

                                        echo"<br>";
                                        echo"<br>";
                                        echo"<p class='text-center '";
                                        echo '<div class="col-sm-6  col-md-4 form-check">';
                                        echo '<input class="form-check-input" type="radio" id="pregunta_' . $row['id_pregunta'] . '_' . $opcion['nombre'] . '" name="respuesta_' . $row['id_pregunta'] . '" value="' . $opcion['nombre'] . '" required>';
                                        echo '<label class="form-check-label" for="pregunta_' . $row['id_pregunta'] . '_' . $opcion['nombre'] . '">' . $opcion['nombre'] . '</label>';
                                        echo '</div>';
                                        
                                        echo"</p>";
                                       
                                        



                                    }
                                                     
                                    echo '</div>';
                                }
                      
                                break;
                        

                default:
                    echo '<tr><td colspan="2">Tipo de pregunta no soportado.</td></tr>';
                    break;
            }
        }

        echo '</tbody>';
        echo '</table>';
        echo '<input type="hidden" name="token" value="' . $token . '">';
        echo '<input type="hidden" name="id_usuario" value="' . $id_usuario . '">';
        echo '<input type="hidden" name="id_encuesta" value="' . $id_encuesta . '">';
        echo '<div class="text-center mt-3">';

     
            echo '<div class="d-grid gap-2 col-6 mx-auto">
                     <button type="submit"  class="custom-button" id="submitButton">Enviar</button>
                 </div>';

        echo '</div>';
        echo '</form>';
    } else {
        echo "No se encontraron preguntas para esta encuesta.";
    }
}







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

