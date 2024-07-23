<?php
include "./conexion/conexion.php";
include "funciones.php";
session_start();

if (!isset($_SESSION['id_registro'])) {
    $_SESSION['id_registro'] = bin2hex(openssl_random_pseudo_bytes(16));
}

$id_registro = $_SESSION['id_registro'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['mostrar_segundo_formulario'])) {
    mostrarFormulario($conn, 5, $id_registro, true, 0);
    exit;
}

$sql_check = "SELECT COUNT(*) as count FROM reg_visit WHERE id_registro = '$id_registro'";
$result_check = $conn->query($sql_check);
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] == 0) {
    $sql = "INSERT INTO reg_visit (id_registro) VALUES ('$id_registro')";
    if ($conn->query($sql) === TRUE) {
        echo "Sesión almacenada correctamente. ID: " . $conn->insert_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "El id_registro ya existe en la base de datos.";
    echo "$id_registro";
}

function mostrarFormulario($conn, $id_encuesta, $id_registro, $esUltimaEncuesta, $contadorInicial) {
    $sql_nombre = "SELECT nombre FROM form WHERE id_encuesta = $id_encuesta";
    $result_nombre = $conn->query($sql_nombre);

    if ($result_nombre->num_rows > 0) {
        $row_nombre = $result_nombre->fetch_assoc();
        $nombre_encuesta = $row_nombre['nombre'];
        echo "<div class='titulo'>$nombre_encuesta</div>";
    } else {
        echo "<div class='titulo'>No se encontró el nombre de la encuesta.</div>";
    }

    $sql_preguntas = "SELECT id_pregunta, pregunta, tipo_pregunta, conf FROM preguntas WHERE id_encuesta = $id_encuesta";
    $result_preguntas = $conn->query($sql_preguntas);




    if ($result_preguntas->num_rows > 0) {
        echo '<form id="encuesta_form_' . $id_encuesta . '" action="procesar_respuestas.php" method="POST">';
        echo '<input type="hidden" name="id_registro" value="' . $id_registro . '">';
        echo '<table border="1">';
        echo '<tr><th>Pregunta</th><th>Respuesta</th></tr>';     
        $contador = $contadorInicial;
        while ($row = $result_preguntas->fetch_assoc()) {
            echo '<tr class="pregunta"';
            if ($contador >= 2) {
                echo ' style="display: none;"';
            }
            echo '>';
            echo '<td>', htmlspecialchars($row["pregunta"]), '</td>';
            
            if ($row["tipo_pregunta"] === 'text') {
                echo '<td>', crearCampoLibre($row["id_pregunta"]), '</td>';
            } elseif ($row["tipo_pregunta"] === 'lista') {
                $campo_lista = crearCampoLista($conn, $row["id_pregunta"], $row["conf"]);
                echo '<td>', $campo_lista, '</td>';
            } elseif ($row["tipo_pregunta"] === 'checkbox') {
                $campo_checkbox = crearCampoCheckbox($conn, $row["id_pregunta"], $row["conf"]);
                echo '<td>', $campo_checkbox, '</td>';
            } elseif ($row["tipo_pregunta"] === 'radio') {
                $campo_radio = crearCampoRadio($conn, $row["id_pregunta"], $row["conf"]);
                echo '<td>', $campo_radio, '</td>';
            } else {
                echo '<td>Tipo de pregunta no soportado</td>';
            }
            echo '</tr>';
            $contador++;
        }
        echo '</table>';
        
        if ($esUltimaEncuesta) {
            echo '<br><input type="submit" value="Enviar respuestas" id="submit_encuesta_' . $id_encuesta . '">';
        } else {
           
        }  
        
        echo '<br><input type="submit" value="Enviar respuestas" id="submit_encuesta_' . $id_encuesta . '">';
        echo '</form>';
    } else {
        echo "Sin resultados";
    }
}



if (isset($_GET['id_encuesta'])) {
    $id_encuesta = (int)$_GET['id_encuesta'];
    $esUltimaEncuesta = ($id_encuesta == 5); 
    mostrarFormulario($conn, $id_encuesta, $id_registro, $esUltimaEncuesta, 0);
}
?>

<script>
function mostrarSiguienteFormulario(id_encuesta, id_registro) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "?mostrar_segundo_formulario=1&id_encuesta=" + id_encuesta + "&id_registro=" + id_registro, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);  // Verificar la respuesta
            var div = document.createElement('div');
            div.innerHTML = xhr.responseText;
            document.body.appendChild(div);
        }
    };
    xhr.send();
}
</script>

<style>  
        body {   
            background-image: url('1.jpg');
            background-size: cover;
            background-repeat: no-repeat;  
            background-position: top;
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        .titulo {
            width: 70%;
            background-color: #2ecc71;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            font-size: 2.5em;
            font-weight: bold;
            border-radius: 15px;
        }

        form {
            max-width: 1000px;
            width: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.0), rgba(0, 0, 0, 0));                                         
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        input[type="submit"] {
            background-color: #2ecc71;
            color: #ffffff; 
            border: none;
            padding: 15px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
            transition: background-color 0.3s, transform 0.3s;
            margin-top: 20px;
            display: block;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #27ae60;
            transform: scale(1.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            border: 1px solid #dddddd;
            text-align: left;
            font-size: 1.1em;
            line-height: 1.5; /* Espacio entre líneas */
        }

        th {
            background-color: #2ecc71;
            color: #ffffff;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) td {
            background-color: #f2f2f2;
        }

        /* Estilo para campos de entrada de texto */
        input[type="text"], textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1em;
        }

        /* Estilo para selectores */
        select {
            appearance: none; /* Ocultar el estilo nativo del selector */
            background-image: url('arrow-down.png');
            background-repeat: no-repeat;
            background-position: calc(100% - 10px) center;
            padding-right: 30px; /* Ajuste para el ícono del selector */
        }

        /* Estilo para checkboxes */
        .checkbox-group {
            display: flex;
            align-items: center;
        }

        .checkbox-group label {
            margin-right: 10px;
        }

        /* Estilo para radios */
        .radio-group {
            display: flex;
            align-items: center;
        }

        .radio-group label {
            margin-right: 10px;
        }
    </style>