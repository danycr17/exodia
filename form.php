<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta name="viewport" con>
    <title>Formulario</title>
</head>
<body>
    <?php

    
    include "./conexion/conexion.php";
    include "funciones.php";

    if (isset($_GET['id_encuesta'])) {
        $id_encuesta = (int)$_GET['id_encuesta'];

        // Consultar el nombre de la encuesta basado en el id_encuesta
        $sql_nombre = "SELECT nombre FROM form WHERE id_encuesta = $id_encuesta";
        $result_nombre = $conn->query($sql_nombre);

        if ($result_nombre->num_rows > 0) {
            $row_nombre = $result_nombre->fetch_assoc();
            $nombre_encuesta = ($row_nombre['nombre']);
            echo "<center><h1>$nombre_encuesta</h1></center>";
        } else {
            echo "No se encontró el nombre de la encuesta.";
        }


        // Consultar las preguntas basadas en el id_encuesta
        $sql_preguntas = "SELECT id_pregunta, pregunta, tipo_pregunta, conf FROM preguntas WHERE id_encuesta = $id_encuesta";
        $result_preguntas = $conn->query($sql_preguntas);

        if ($result_preguntas->num_rows > 0) {
            echo '<form action="procesar_respuestas.php" method="POST">';
            echo '<table border="1">';
            echo '<tr><th>Pregunta</th><th>Respuesta</th></tr>';
            
            while ($row = $result_preguntas->fetch_assoc()) {
                echo '<tr>';
                echo '<td>',$row["pregunta"], '</td>';
                
                if ($row["tipo_pregunta"] === 'text') {
                    echo '<td>', crearCampoLibre($row["id_pregunta"]), '</td>';
                
                } elseif ($row["tipo_pregunta"] === 'lista') {
                    $campo_lista = crearCampoLista($conn, $row["id_pregunta"], $row["conf"]);
                    echo '<td>', $campo_lista, '</td>';
                } elseif ($row["tipo_pregunta"] === 'checkbox') {
                    $campo_checkbox = crearCampoCheckbox($conn, $row["id_pregunta"], $row["conf"]);
                    echo '<td>', $campo_checkbox, '</td>';
                   
                } elseif ($row["tipo_pregunta"] === 'radio') {
                    $campo_Radio = crearCampoRadio($conn, $row["id_pregunta"], $row["conf"]);
                    echo '<td>', $campo_Radio, '</td>';
                    //echo 'tipo_pregunta';
                } else {
                    echo '<td>Tipo de pregunta  soportado</td>';
                }
                echo '</tr>';
            }

            echo '</table>';
            echo '<br><input type="submit" value="Enviar respuestas">';
            echo '</form>';
        } else {
            echo "Sin resultados";
        }
    } else {
        echo "No se ha seleccionado ninguna encuesta.";
    }



    $conn->close();
    ?>

    <style>  
    body {   
    background-image: url('1.jpg');
    background-size: cover;
    background-repeat: no-repeat;  
    background-position: top;
    }


        form {
            max-width: 850px;
            margin: 0 auto;
            
        }

        input[type="submit"] {
            background-color: #0074D9;
            color: #ffffff; 
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #dddddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</body>
</html>