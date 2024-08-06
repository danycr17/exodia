<?php
include "./conexion/conexion.php";
include "funciones.php";

session_start();

// Asegúrate de que id_registro se establezca correctamente en la sesión
if (!isset($_SESSION['id_registro'])) {
    $_SESSION['id_registro'] = uniqid(); // Genera un ID único para la sesión
}
$id_registro = $_SESSION['id_registro'];

// Lógica para determinar si el primer formulario ha sido completado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['form_num']) && $_POST['form_num'] == 1) {
        // Aquí puedes procesar los datos del primer formulario
        // Actualiza la sesión para indicar que el primer formulario ha sido completado
        $_SESSION['form1_completed'] = true;
        // Redirige al mismo script para evitar el resubido del formulario
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } elseif (isset($_POST['form_num']) && $_POST['form_num'] == 2) {
        // Aquí puedes procesar los datos del segundo formulario
        // Actualiza la sesión o realiza cualquier otra lógica necesaria
        echo "Segundo formulario completado";
        exit;
    }
}

// Determina si el primer formulario ha sido completado
$form1_completed = isset($_SESSION['form1_completed']) && $_SESSION['form1_completed'] === true;

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
    <input type="hidden" name="form_num" value="2">
    <?php
    formulario($conn, 5, $id_registro, 0, 'Encuesta Secundaria', 2);
    ?>
    <br><input type="submit" value="Enviar respuestas" id="submit_encuesta_secundaria">
</form>
<?php endif; ?>

</body>
</html>