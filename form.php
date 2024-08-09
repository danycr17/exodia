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

// Imprimir el ID de sesión
echo "ID de sesión: " . session_id() . "<br>";
echo "ID de registro: " . $_SESSION['id_registro'] . "<br>";

// Check if the first form has been completed
$form1_completed = isset($_SESSION['form1_completed']) ? $_SESSION['form1_completed'] : false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['form_num']) && $_POST['form_num'] == 1) {
        // Mark the first form as completed
        $_SESSION['form1_completed'] = true;
        $form1_completed = true;
    } elseif (isset($_POST['form_num']) && $_POST['form_num'] == 2) {
        // Process the second form as needed
        // For now, just display a message
        echo "Formulario secundario completado.";
        // Reset session or perform any other necessary actions
        session_unset();
        session_destroy();
        exit();
    }
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
    <input type="hidden" name="id_registro" value="<?php echo($id_registro); ?>">
    <input type="hidden" name="form_num" value="1">
    <?php formulario($conn, 4, $id_registro, 0, 'Encuesta Principal', 1); ?>
    <br><button type="button" onclick="finalizarFormulario()">Finalizar Encuesta Principal</button>
</form>
<?php else: ?>
<!-- Formulario para Encuesta Secundaria -->
<form id="encuesta_form_secundaria" action="" method="POST">
    <input type="hidden" name="id_registro" value="<?php echo($id_registro); ?>">
    <input type="hidden" name="form_num" value="2">
    <?php formulario($conn, 5, $id_registro, 0, 'Encuesta Secundaria', 2); ?>
    <br><input type="submit" value="Enviar respuestas" id="submit_encuesta_secundaria">
</form>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="text"], select, input[type="checkbox"], input[type="radio"]').forEach(function(input) {
        input.addEventListener('change', function(event) {
            let formData = new FormData();
            formData.append('id_registro', '<?php echo($id_registro); ?>');
            formData.append('form_num', event.target.closest('form').querySelector('input[name="form_num"]').value);
            formData.append(event.target.name, event.target.value);

            fetch('guardar_respuesta.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Puedes manejar la respuesta del servidor aquí
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});

function finalizarFormulario() {
    let form = document.querySelector('form');
    let formData = new FormData(form);

    fetch('finalizar_formulario.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data === 'Formulario completado.' || data === 'Formulario principal completado.') {
            window.location.reload();
        } else {
            console.log(data); // Maneja los mensajes del servidor
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>

</body>
</html>
