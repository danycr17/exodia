<?php
include './conexion/conexion.php';

// Función para obtener el tipo de campo basado en el tipo de pregunta y configuración
function obtenerTipoCampo($tipo_pregunta, $conf) {
    $conf = htmlspecialchars($conf, ENT_QUOTES, 'UTF-8'); // Escapar caracteres especiales para seguridad
    switch ($tipo_pregunta) {
        case 'text':
            return "<input type='text' name='respuesta_$conf' required>";
        case 'textarea':
            return "<textarea name='respuesta_$conf' required></textarea>";
        case 'radio':
            $opciones = explode(',', $conf); 
            $html = "";
            foreach ($opciones as $opcion) {
                $opcion = trim($opcion); // Elimina espacios innecesarios
                $html .= "<input type='radio' name='respuesta_$conf' value='$opcion' required> $opcion<br>";
            }
            return $html;
        case 'checkbox':
            $opciones = explode(',', $conf);
            $html = "";
            foreach ($opciones as $opcion) {
                $opcion = trim($opcion); 
                $html .= "<input type='checkbox' name='respuesta_{$conf}[]' value='$opcion'> $opcion<br>";
            }
            return $html;
        case 'select':
            $opciones = explode(',', $conf); 
            $html = "<select name='respuesta_$conf' required>";
            foreach ($opciones as $opcion) {
                $opcion = trim($opcion); // Elimina espacios innecesarios
                $html .= "<option value='$opcion'>$opcion</option>";
            }
            $html .= "</select>";
            return $html;
        default:
            return "<input type='text' name='respuesta_$conf' required>"; // Default to text input
    }
}



// Inicializa las variables
$empresa = $nombre = $area = "";
$id_encuesta = isset($_GET['id_encuesta']) ? (int)$_GET['id_encuesta'] : 0; // Obtener ID de encuesta desde GET

// Verifica si el formulario de registro ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre_completo'])) {
    // Verifica si las claves existen en el arreglo $_POST antes de usarlas
    $empresa = isset($_POST['nombre_de_la_empresa_o_organización']) ? $_POST['nombre_de_la_empresa_o_organización'] : '';
    $nombre = isset($_POST['nombre_completo']) ? $_POST['nombre_completo'] : '';
    $area = isset($_POST['Área']) ? $_POST['Área'] : '';
    $id_encuesta = isset($_POST['id_encuesta']) ? (int)$_POST['id_encuesta'] : 0; // Obtener ID de encuesta desde POST

    // Guardar los datos del registro en la tabla `usuarios_registro`
    $sql_insert_usuario = "INSERT INTO usuarios_registro (empresa, nombre_completo, area) VALUES ('$empresa', '$nombre', '$area')";
    if ($conn->query($sql_insert_usuario) === TRUE) {
        $id_usuario = $conn->insert_id; // Obtener el ID del usuario registrado
        header("Location: form.php?id_encuesta=$id_encuesta&id_usuario=$id_usuario"); // Redirige a la encuesta principal
        exit(); // Asegúrate de salir después de redirigir
    } else {
        echo "Error al insertar el usuario: " . $conn->error;
    }
} else {
    // Consulta SQL para obtener las preguntas de registro
    $sql_registro = "SELECT id_pregunta, pregunta, tipo_pregunta, conf FROM preguntas_registro";
    $result_registro = $conn->query($sql_registro);

    if ($result_registro->num_rows > 0) {
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
        echo "<input type='hidden' name='id_encuesta' value='$id_encuesta'>"; // Asegúrate de incluir el ID de la encuesta
        while ($row_registro = $result_registro->fetch_assoc()) {
            $campo = strtolower(str_replace(" ", "_", $row_registro["pregunta"]));
            echo $row_registro["pregunta"] . ": " . obtenerTipoCampo($row_registro["tipo_pregunta"], $campo) . "<br>";
        }
        echo "<input type='submit' value='Continuar'>";
        echo "</form>";
    } else {
        echo "No hay preguntas de registro disponibles.";
    }
}
$conn->close();
?>
