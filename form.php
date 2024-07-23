<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styleForm.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
include "./conexion/conexion.php";
include "funciones.php";
session_start();

if (!isset($_SESSION['id_registro'])) {
    $_SESSION['id_registro'] = bin2hex(openssl_random_pseudo_bytes(16));
}

$id_registro = $_SESSION['id_registro'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['mostrar_segundo_formulario'])) {
    formularioDos($conn, 5, $id_registro, true, 0);
    exit;
}

$sql_check = "SELECT COUNT(*) as count FROM reg_visit WHERE id_registro = '$id_registro'";
$result_check = $conn->query($sql_check);
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] == 0) {
    $sql = "INSERT INTO reg_visit (id_registro) VALUES ('$id_registro')";
    if ($conn->query($sql) === TRUE) {
        echo "Sesión almacenada correctamente. ID: " . $conn->insert_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "El id_registro ya existe en la base de datos.";
    echo "$id_registro";
}

function formulario($conn, $id_encuesta, $id_registro, $contadorInicial, $titulo) {
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
            if ($contador >= 2) {
                echo ' style="display: none;"';
            }
            echo '>';
            echo '<td>', htmlspecialchars($row["pregunta"]), '</td>';

            if ($row["tipo_pregunta"] === 'text') {
                echo '<td>', crearCampoLibre($row["id_pregunta"]), '</td>';
            } elseif ($row["tipo_pregunta"] === 'lista') {
                $campo_lista = crearCampoLista($conn, $row["id_pregunta"], $row["conf"]);
                echo '<td>', $campo_lista, '</td>';
            } elseif ($row["tipo_pregunta"] === 'checkbox') {
                $campo_checkbox = crearCampoCheckbox($conn, $row["id_pregunta"], $row["conf"]);
                echo '<td>', $campo_checkbox, '</td>';
            } elseif ($row["tipo_pregunta"] === 'radio') {
                $campo_radio = crearCampoRadio($conn, $row["id_pregunta"], $row["conf"]);
                echo '<td>', $campo_radio, '</td>';
            } else {
                echo '<td>Tipo de pregunta no soportado</td>';
            }
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
    <input type="hidden" name="id_registro" value="<?php echo $id_registro; ?>">
    <?php
    formulario($conn, 4, $id_registro, 0, 'Encuesta Principal');
    formulario($conn, 5, $id_registro, 0, 'Encuesta Secundaria');
    ?>
    <br><input type="submit" value="Enviar respuestas" id="submit_encuesta">
</form>

</body>
</html>
