<?php
include "./conexion/conexion.php";
include "funciones.php";

session_start();

// Asegúrate de que id_registro se establezca correctamente en la sesión
if (isset($_SESSION['id_registro'])) {
    $id_registro = $_SESSION['id_registro'];
} else {
    $id_registro = null; // O cualquier valor por defecto que prefieras
    $_SESSION['id_registro'] = $id_registro;
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí puedes agregar la lógica para procesar las respuestas del formulario
    // Por ejemplo, guardar las respuestas en la base de datos

    // Después de procesar el formulario, actualiza $form1_completed
    if (isset($_POST['form_num']) && $_POST['form_num'] == 1) {
        $_SESSION['form1_completed'] = true;
    }
}

// Aquí se debería definir $form1_completed basado en la sesión
$form1_completed = isset($_SESSION['form1_completed']) ? $_SESSION['form1_completed'] : false;

// Función para mostrar el formulario
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
            echo '<tr class="pregunta">';
            echo '<td>', htmlspecialchars($row["pregunta"]), '</td>';

            echo '<td>';
            if ($row["tipo_pregunta"] === 'text') {
                echo crearCampoLibre($row["id_pregunta"], $form_num);
            } elseif ($row["tipo_pregunta"] === 'lista') {
                echo crearCampoLista($conn, $row["id_pregunta"], $row["conf"], $form_num);
            } elseif ($row["tipo_pregunta"] === 'checkbox') {
                echo crearCampoCheckbox($conn, $row["id_pregunta"], $row["conf"], $form_num);
            } elseif ($row["tipo_pregunta"] === 'radio') {
                echo crearCampoRadio($conn, $row["id_pregunta"], $row["conf"]);
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
// Depuración: Verifica el estado de $form1_completed
echo "<pre>";
echo "form1_completed: " . ($form1_completed ? 'true' : 'false') . "\n";
echo "id_registro: " . htmlspecialchars($id_registro) . "\n";
echo "</pre>";
?>

<?php if (!$form1_completed): ?>
<!-- Formulario para Encuesta Principal -->
<form id="encuesta_form_principal" action="" method="POST">
    <input type="hidden" name="id_registro" value="<?php echo htmlspecialchars($id_registro); ?>">
    <input type="hidden" name="form_num" value="1">
    <?php formulario($conn, 4, $id_registro, 0, 'Encuesta Principal', 1); ?>
    <br><input type="submit" value="Enviar respuestas" id="submit_encuesta_principal">
</form>
<?php else: ?>
<!-- Formulario para Encuesta Secundaria -->
<form id="encuesta_form_secundaria" action="" method="POST">
    <input type="hidden" name="id_registro" value="<?php echo htmlspecialchars($id_registro); ?>">
    <?php
    formulario($conn, 5, $id_registro, 0, 'Encuesta Secundaria', 2);
    ?>
    <br><input type="submit" value="Enviar respuestas" id="submit_encuesta">
</form>
<?php endif; ?>

</body>
</html>
