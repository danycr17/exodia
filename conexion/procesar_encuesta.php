<?php
include "./conexion/conexion.php";


$id_usuario = $_POST['id_usuario'];
$id_encuesta = $_POST['id_encuesta'];

echo "ID de Usuario: " . $id_usuario . "<br>";
echo "ID de Encuesta: " . $id_encuesta;



    
session_start(); // Iniciar la sesión



if ($id_usuario <= 0 || $id_encuesta <= 0) {
    die("ID de usuario o encuesta inválido.");
}

// Almacenar los datos en la sesión
$_SESSION['id_usuario'] = $id_usuario;
$_SESSION['id_encuesta'] = $id_encuesta;

// Redirigir a la página de formulario
header("Location: formulario_encuesta.php");
exit();



    $id_usuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;
    if ($id_usuario <= 0) {
        die("ID de usuario inválido.");
    }
        $id_encuesta = isset($_GET['id_encuesta']) ? intval($_GET['id_encuesta']) : 0;
    if ($id_encuesta <= 0) {
        die("ID de encuesta inválido.");
    }
    $sql = "INSERT INTO respuestas (id_usuario, id_pregunta, respuesta, encuesta_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'respuesta_') === 0) {
            $id_pregunta = intval(substr($key, strlen('respuesta_')));
            if (is_array($value)) {
                foreach ($value as $respuesta) {
                    $stmt->bind_param("iisi", $id_usuario, $id_pregunta, $respuesta, $id_encuesta);
                    if (!$stmt->execute()) {
                        echo "Error al guardar la respuesta: " . $stmt->error;
                    }
                }
            } else {
                $stmt->bind_param("iisi", $id_usuario, $id_pregunta, $value, $id_encuesta);
                if (!$stmt->execute()) {
                    echo "Error al guardar la respuesta: " . $stmt->error;
                }
            }
        }
    }
    

        header("Location: ../salida.php");
    exit();



?>





