<?php

function crearCampoLibre($id_pregunta) {
    return '<input type="text" name="respuesta[' . htmlspecialchars($id_pregunta, ENT_QUOTES, 'UTF-8') . ']">';
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

?>

