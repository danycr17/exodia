<?php
include "./conexion/conexion.php";
include "funciones.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_num = $_POST['form_num'];

    if ($form_num == 1) {
        $_SESSION['form1_completed'] = true;
        echo "Formulario principal completado.";
    } elseif ($form_num == 2) {
        session_unset();
        session_destroy();
        echo "Formulario completado.";
    } else {
        echo "Número de formulario no válido.";
    }
} else {
    echo "Método de solicitud no permitido.";
}
?>
