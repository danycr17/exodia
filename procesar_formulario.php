<?php
include "./conexion/conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_num = $_POST['form_num'] ?? '';
    $respuestas = $_POST;

    echo "Form Num: $form_num\n";
    print_r($respuestas);

    if ($form_num == 1) {
        $empresa = $respuestas['empresa'] ?? '';
        $nombre = $respuestas['nombre'] ?? '';
        $departamento_area = $respuestas['departamento_area'] ?? '';

        $sql = "INSERT INTO reg_visit (empresa, nombre, departamento_area) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $empresa, $nombre, $departamento_area);

        if ($stmt->execute()) {
            $id_registro = $conn->insert_id; // Recupera el id_registro generado
            echo "Respuestas guardadas correctamente para id_registro: $id_registro, form_num: $form_num";
            // Aquí puedes devolver el id_registro al cliente para usarlo en el siguiente paso del formulario
        } else {
            http_response_code(500);
            echo "Error al guardar las respuestas: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($form_num == 2) {
        $id_registro = $_POST['id_registro'] ?? '';
        foreach ($respuestas['respuesta'] as $id_pregunta => $respuesta) {
            if ($id_pregunta !== 'id_registro' && $id_pregunta !== 'form_num') {
                $sql = "INSERT INTO respuestas (id_registro, id_pregunta, respuesta) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iis", $id_registro, $id_pregunta, $respuesta);

                if ($stmt->execute()) {
                    echo "Respuestas guardadas correctamente para id_registro: $id_registro, form_num: $form_num";
                } else {
                    http_response_code(500);
                    echo "Error al guardar las respuestas: " . $stmt->error;
                    break;
                }
            }
        }
        $stmt->close();
    } else {
        echo "Número de formulario no reconocido.";
    }
}
?>
