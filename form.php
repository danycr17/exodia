<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styleForm.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>

<?php
include "./conexion/conexion.php";
include "funciones.php";

session_start();

if (isset($_SESSION['id_registro'])) {
    $id_registro = $_SESSION['id_registro'];
} else {
    // Handle the case where the session variable is not set
    $id_registro = null; // or any default value you prefer
  $_SESSION['id_registro'] = $id_registro;

 
}

function formulario($conn, $id_encuesta, $id_registro, $contadorInicial, $titulo, $form_num) {
    $sql_nombre = "SELECT nombre FROM form WHERE id_encuesta = $id_encuesta";
    $result_nombre = $conn->query($sql_nombre);

    if ($result_nombre->num_rows > 0) {
        $row_nombre = $result_nombre->fetch_assoc();
        $nombre_encuesta = $row_nombre['nombre'];
        echo "<div class='titulo'>$nombre_encuesta</div>";
    } else {
        echo "<div class='titulo'>$titulo</div>";
    }

    $sql_preguntas = "SELECT id_pregunta, pregunta, tipo_pregunta, conf FROM preguntas WHERE id_encuesta = $id_encuesta";
    $result_preguntas = $conn->query($sql_preguntas);

    if ($result_preguntas->num_rows > 0) {
        echo '<table border="1">';
        echo '<tr><th>Pregunta</th><th>Respuesta</th></tr>';
        $contador = $contadorInicial;
        while ($row = $result_preguntas->fetch_assoc()) {
            echo '<tr class="pregunta"';
            if ($contador >= 3) {
                echo ' style="display: none;"';
            }
            echo '>';
            echo '<td>', htmlspecialchars($row["pregunta"]), '</td>';

            echo '<td>';
            if ($row["tipo_pregunta"] === 'text') {
                echo crearCampoLibre($row["id_pregunta"], $form_num);
            } elseif ($row["tipo_pregunta"] === 'lista') {
                echo crearCampoLista($conn, $row["id_pregunta"], $row["conf"], $form_num);
            } elseif ($row["tipo_pregunta"] === 'checkbox') {
                echo crearCampoCheckbox($conn, $row["id_pregunta"], $row["conf"], $form_num);
            } elseif ($row["tipo_pregunta"] === 'radio') {
                // Adjust the function call to match the function definition
                echo crearCampoRadio($conn, $row["id_pregunta"], $row["conf"]); // Assuming crearCampoRadio accepts 3 arguments
            } else {
                echo 'Tipo de pregunta no soportado';
            }
            echo '</td>';
            echo '</tr>';
            $contador++;
            }
            echo '</table>';
            } else {
            echo "Sin resultados";
            }
            }
          
?>

<form id="encuesta_form" action="procesar_respuestas.php" method="POST">
    <input type="hidden" name="id_registro" value="<?php echo($id_registro); ?>">
    <?php
    formulario($conn, 4, $id_registro, 0, 'Encuesta Principal', 1);
    formulario($conn, 5, $id_registro, 0, 'Encuesta Secundaria', 2);
    ?>
    <br><input type="submit" value="Enviar respuestas" id="submit_encuesta">
</form>

</body>
</html>