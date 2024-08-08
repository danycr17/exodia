<?php
include "./conexion/conexion.php";
include "funciones.php";

session_start();
if (isset($_SESSION['id_registro'])) {
    $id_registro = $_SESSION['id_registro'];
} else {
    $id_registro = uniqid(); 
    $_SESSION['id_registro'] = $id_registro;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>Formulario enviado\n";
    print_r($_POST);
    echo "</pre>";
    if (isset($_POST['form_num'])) {
        if ($_POST['form_num'] == 1) {
            $_SESSION['form1_completed'] = true;
            echo "<pre>form1_completed se ha establecido a true</pre>";
        } elseif ($_POST['form_num'] == 2) {
            $_SESSION['form2_completed'] = true;
            echo "<pre>form2_completed se ha establecido a true</pre>";
        }
    }
}

$form1_completed = isset($_SESSION['form1_completed']) ? $_SESSION['form1_completed'] : false;
$form2_completed = isset($_SESSION['form2_completed']) ? $_SESSION['form2_completed'] : false;

if ($form1_completed && $form2_completed) {
    session_destroy();
    echo "<pre>Sesión destruida</pre>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="styleForm.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</head>
<body>
<?php
echo "<pre>";
echo "form1_completed: " . ($form1_completed ? 'true' : 'false') . "\n";
echo "form2_completed: " . ($form2_completed ? 'true' : 'false') . "\n";
echo "id_registro: " .($id_registro) . "\n";
echo "</pre>";
?>
<?php if (!$form1_completed): ?>
<!-- Formulario para Encuesta Principal -->
<form id="encuesta_form_principal" action="" method="POST">
    <input type="hidden" name="id_registro" value="<?php echo $id_registro; ?>">
    <input type="hidden" name="form_num" value="1">
    <?php formulario($conn, 4, $id_registro, 0, 'Encuesta Principal', 1); ?>
    <br><input type="submit" value="Enviar respuestas" id="submit_encuesta_principal">
</form>
<?php elseif (!$form2_completed): ?>
<!-- Formulario para Encuesta Secundaria -->
<form id="encuesta_form_secundaria" action="" method="POST">
    <input type="hidden" name="id_registro" value="<?php echo $id_registro; ?>">
    <input type="hidden" name="form_num" value="2">
    <?php formulario($conn, 5, $id_registro, 0, 'Encuesta Secundaria', 2); ?>
    <br><input type="submit" value="Enviar respuestas" id="submit_encuesta_secundaria">
</form>
<?php endif; ?>

<div id="mensaje-confirmacion" class="mensaje-confirmacion" style="display: none;">
    Respuestas guardadas correctamente.
</div>
<div id="mensaje-error" class="mensaje-error" style="display: none;">
    Error al guardar las respuestas.
</div>

<script>
$(document).ready(function() {
    $('form input, form select, form textarea').on('input change', function() {
        var formData = $(this).closest('form').serialize();
        var contenedor = $(this).closest('.contenedor-respuestas');
        console.log('Datos del formulario:', formData); // Mensaje de depuración

        $.ajax({
            type: 'POST',
            url: 'procesar_formulario.php',
            data: formData,
            success: function(response) {
                console.log('Datos enviados: ' + response);
                contenedor.removeClass('error').addClass('guardado');
                $('#mensaje-confirmacion').show().delay(3000).fadeOut();
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error); // Mensaje de depuración
                contenedor.removeClass('guardado').addClass('error');
                $('#mensaje-error').show().delay(3000).fadeOut();
            }
        });
    });
});
</script>

</body>
</html>
