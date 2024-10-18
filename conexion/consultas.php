<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>        
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
        

    </head>
<?php
include "../conexion/conexion.php";
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    
    exit;
}

if (!$conn) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

$id_encuesta = isset($_POST['encuesta']) ? intval($_POST['encuesta']) : 0;
$inicio = isset($_POST['inicio_fecha']) ? $_POST['inicio_fecha'] : '';
$final = isset($_POST['final_fecha']) ? $_POST['final_fecha'] : '';

echo "<br>"; 
echo "<div class='container rounded'>";
echo "<div class='container '>";
echo "<br>"; 
echo "<div class='card shadow-lg border-0'>";

echo "<div class='card-header rounded  bg-success text-white text-center'>";

echo "<h3>Resultados de Encuesta</h3>";
echo "</div>";
echo "</div>";
echo "<div class='container text-end my-3'>";

echo "<a href='consulta_exp.php?e=$id_encuesta&fi=$inicio&ff=$final' class='btn btn-success'>Exportar</a>";
echo "</div>";


$query_preguntas = "SELECT id_pregunta, orden, pnombre FROM preguntas WHERE id_encuesta = $id_encuesta AND tipo_pregunta != 'titulo' ORDER BY orden";
$result_preguntas = $conn->query($query_preguntas);
$preguntas = [];
$pnombre = [];

while ($row_pregunta = $result_preguntas->fetch_assoc()) {
    $preguntas[] = $row_pregunta['id_pregunta'];
    $pnombre[] = $row_pregunta['pnombre'];
}


$query_tabla = "SELECT * FROM usuarios_registro WHERE id_enc = $id_encuesta AND fecha_registro BETWEEN '$inicio 00:00:00' AND '$final 23:59:59' ORDER BY fecha_registro DESC  ";
$result = $conn->query($query_tabla);

echo "<div class='container mt-5'>";
echo "<body>";
echo "<div class='card-body'>";
echo "<div class='table-responsive'>";
echo "<table class='table table-striped table-hover table-bordered'>";

echo '<table id="example" class="table table-striped table-bordered" style="width:100%;">';
echo "<thead class='table-success'>";
echo "<tr>";
echo "<th>#</th>";
echo "<th>EMPRESA</th>";
echo "<th>NOMBRE</th>";
echo "<th>DEPARTAMENTO</th>";
echo "<th>FECHA</th>";

foreach ($pnombre as  $ncolumna) {
     echo "<th>" . ($ncolumna) . "</th>";
}
echo "</tr>";
echo "</thead>";
echo "<tbody>";


if ($result->num_rows > 0) {
    
$i = 1;

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

        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td>{$row['empresa']}</td>";
        echo "<td>{$row['nombre_completo']}</td>";
        echo "<td>{$row['area']}</td>";

        $date = new DateTime($row['fecha_registro']);
        echo "<td>" . $date->format('d/m/Y H:i') . "</td>";
        
        foreach ($respuestas as $id_pregunta) {
            echo "<td>$id_pregunta</td>";
        }
        echo "</tr>";
        $i++;
    }
} else {
    echo "<tr><td colspan='" . (count($preguntas) + 5) . "' class='text-center'>No se encontraron registros.</td></tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>";

echo "</div>";
echo "</div>";

$conn->close();


echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+CB9EXW9LtB5ptNkF0y6RWYpTw0QT' crossorigin='anonymous'></script>";
echo "</body>";
echo "</html>";

echo "</div>";
?>


<script> 

$(document).ready(function() {
    $('#example').DataTable();
} );


</script>


<style>

.container {
  background-color: #f0fdf2; 
  border-radius: 15;
}

body{
background-image: url('../img/brg.jpg');
}
</style>