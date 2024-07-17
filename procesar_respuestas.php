<?php
include "./conexion/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['respuesta']) && is_array($_POST['respuesta'])) {
        $respuestas = $_POST['respuesta'];
        $empresa = '';
        $nombre = '';

        foreach ($respuestas as $id_pregunta => $respuesta) {
            $id_pregunta = (int)$id_pregunta;
           
            if (is_array($respuesta)) {
                
                $respuesta = implode(', ', array_map(array($conn, 'real_escape_string'), $respuesta));
            } else {
               
                $respuesta = $conn->real_escape_string($respuesta);
                echo $respuesta;
            }

            $sql = "SELECT pregunta FROM preguntas WHERE id_pregunta = $id_pregunta";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $pregunta = $row["pregunta"];

                
                $sql_insert_respuestas = "INSERT INTO respuestas (id_pregunta, respuesta) VALUES ('$id_pregunta', '$respuesta')";
                $conn->query($sql_insert_respuestas);
                echo $sql_insert_respuestas;

           
                if (strpos($pregunta, 'Empresa') !== false) {
                    $empresa = $respuesta;
                } elseif (strpos($pregunta, 'Cual es tu nombre') !== false) {
                    $nombre = $respuesta;
                }
            }
    } 
       
        }
        if ($nombre && $empresa)
         {
            $sql = "INSERT INTO reg_visit (nombre, empresa) VALUES ('$nombre', '$empresa')";

            if ($conn->query($sql) === TRUE) {
                echo "Respuestas guardadas correctamente";
                
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Faltan algunas respuestas específicas. Asegúrate de completar todas las preguntas.";
        }
    } else {
        echo "No se recibieron respuestas válidas.";
    }


exit;

 //header('Location: Index.php');


$conn->close();
?>