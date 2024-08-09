<?php

function crearCampoLibre($id_pregunta) {
    return '<input type="text" name="respuesta[' .($id_pregunta ) . ']">';
}

function crearCampoLista($conn, $id_pregunta, $grupo) {
    $grupo = $conn->real_escape_string($grupo);
    $sql_lista = "SELECT nombre FROM pregunta_detalle WHERE grupo='$grupo'";
    $result_lista = $conn->query($sql_lista);
    $campo = '';

    if ($result_lista->num_rows > 0) {
        $campo .= '<select name="respuesta[' . htmlspecialchars($id_pregunta, ENT_QUOTES, 'UTF-8') . ']">';
        while ($row_lista = $result_lista->fetch_assoc()) {
            $campo .= '<option value="' . htmlspecialchars($row_lista["nombre"], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row_lista["nombre"], ENT_QUOTES, 'UTF-8') . '</option>';
        }
        $campo .= '</select>';
    } else {
        $campo .= 'No hay datos disponibles';
    }

    return $campo;
}

function crearCampoCheckbox($conn, $id_pregunta, $grupo) {
    $grupo = $conn->real_escape_string($grupo);
    $sql_lista = "SELECT nombre FROM pregunta_detalle WHERE grupo='$grupo'";
    $result_lista = $conn->query($sql_lista);
    $campo = '';

    if ($result_lista->num_rows > 0) {
        while ($row_lista = $result_lista->fetch_assoc()) {
            $campo .= '<label><input type="checkbox" name="respuesta[' . htmlspecialchars($id_pregunta, ENT_QUOTES, 'UTF-8') . '][]" value="' . htmlspecialchars($row_lista["nombre"], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row_lista["nombre"], ENT_QUOTES, 'UTF-8') . '</label><br>';
        }
    } else {
        $campo .= 'No hay datos disponibles';
    }

    return $campo;
}

function crearCampoRadio($conn, $id_pregunta, $grupo) {
    $grupo = $conn->real_escape_string($grupo);
    $sql_lista = "SELECT nombre FROM pregunta_detalle WHERE grupo='$grupo'";
    $result_lista = $conn->query($sql_lista);
    $campo = '';

    if ($result_lista->num_rows > 0) {
        while ($row_lista = $result_lista->fetch_assoc()) {
            $nombre = htmlspecialchars($row_lista["nombre"], ENT_QUOTES, 'UTF-8');
            $campo .= '<label><input type="radio" name="respuesta[' . $id_pregunta . '][]" value="' . $nombre . '">' . $nombre . '</label><br>';
        }
    } else {
        $campo .= 'No hay datos disponibles';
    }

    return $campo;
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
        echo '<div class="contenedor-respuestas">';
        echo '<table border="1">';
        echo '<tr><th>Pregunta</th><th>Respuesta</th></tr>';
        $contador = $contadorInicial;
        while ($row = $result_preguntas->fetch_assoc()) {
            echo '<tr class="pregunta">';
            echo '<td>',($row["pregunta"]), '</td>';
            echo '<td>';
            if ($row["tipo_pregunta"] === 'text') {
                echo crearCampoLibre($row["id_pregunta"]);
            } elseif ($row["tipo_pregunta"] === 'lista') {
                echo crearCampoLista($conn, $row["id_pregunta"], $row["conf"]);
            } elseif ($row["tipo_pregunta"] === 'checkbox') {
                echo crearCampoCheckbox($conn, $row["id_pregunta"], $row["conf"]);
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
        echo '</div>';
    } else {
        echo "Sin resultados";
    }
}
?>
