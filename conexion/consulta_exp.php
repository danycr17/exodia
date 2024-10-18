

<?php
 include "../conexion/conexion.php";
 session_start();
 
 if (!isset($_SESSION['loggedin'])) {
     header('Location: index.html');
     
     exit;
 }

header("Pragma: public");
header("Expires: 0");
$filename = "Reporte.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    



<?php

include "../conexion/conexion.php";


if (!$conn) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}


$id_encuesta = isset($_GET['e']) ? intval($_GET['e']) : 0;
$inicio = isset($_GET['fi']) ? $_GET['fi'] : '';
$final = isset($_GET['ff']) ? $_GET['ff'] : '';


$query_preguntas = "SELECT id_pregunta, orden, pnombre FROM preguntas WHERE id_encuesta = $id_encuesta AND tipo_pregunta != 'titulo' ORDER BY orden";
$result_preguntas = $conn->query($query_preguntas);



while ($row_pregunta = $result_preguntas->fetch_assoc()) {
    $preguntas[] = $row_pregunta['id_pregunta'];
    $pnombre[] = $row_pregunta['pnombre'];
}

$query_tabla = "SELECT * FROM usuarios_registro WHERE id_enc = $id_encuesta AND fecha_registro BETWEEN '$inicio 00:00:00' AND '$final 23:59:59' ORDER BY fecha_registro DESC";
$result = $conn->query($query_tabla);

echo '<table class="table table-bordered">';
echo '<thead class="thead-light">';
echo '<tr>';
echo '<th>#</th>';
echo '<th>EMPRESA</th>';
echo '<th>NOMBRE</th>';
echo '<th>AREA</th>';
echo '<th>FECHA</th>';

foreach ($pnombre as  $ncolumna) {
    echo "<th>" . ($ncolumna) . "</th>";
}

echo '</tr>';
echo '</thead>';
echo '<tbody>';

$i = 1;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_usuario = $row['id_usuario'];
        $query_res = "SELECT id_pregunta, respuesta FROM respuestas WHERE id_usuario = $id_usuario AND encuesta_id = $id_encuesta ORDER BY id_pregunta";

        $res = $conn->query($query_res);
        $respuestas = array_fill(0, count($preguntas), '');
        if ($res->num_rows > 0) {
            while ($row_res = $res->fetch_assoc()) {
                $id_pregunta = array_search($row_res['id_pregunta'], $preguntas);
                if ($id_pregunta !== false) {
                    if (!empty($respuestas[$id_pregunta])) {
                        $respuestas[$id_pregunta] .= '<br>' . $row_res['respuesta'];
                    } else {
                        $respuestas[$id_pregunta] = $row_res['respuesta'];
                    }
                }
            }
        }


        echo '<tr>';
        echo '<td>' . ($i++) . '</td>';
        echo '<td>' . $row['empresa'] . '</td>';
        echo '<td>' . $row['nombre_completo'] . '</td>';
        echo '<td>' . $row['area'] . '</td>';
        echo '<td>' . $row['fecha_registro'] . '</td>';
       
        foreach ($respuestas as $id_pregunta) {
            echo "<td>$id_pregunta</td>";
        }
        echo "</tr>";
        $i++;
    }
} else {
    echo "<tr><td colspan='" . (count($preguntas) + 5) . "' class='text-center'>No se encontraron registros.</td></tr>";
}
       


echo '</tbody>';
echo '</table>';

$conn->close();



?>


</body>
</html>