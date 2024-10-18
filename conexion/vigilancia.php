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

echo "<br>";
echo "<div class='container rounded'>";
echo "<br>"; 
echo "<div class='card shadow-lg border-0'>";
echo "<div class='card-header rounded bg-success text-white text-center'>";
echo "<h3>Registro de Visitantes/Proveedores</h3>";
echo "</div>";
echo "</div>";
echo "<div class='container text-end my-3'>";
echo "</div>";
$query_tabla = "SELECT * FROM usuarios_registro WHERE id_enc AND fecha_registro AND estado in(1,2,3) ORDER BY fecha_registro DESC";
$result = $conn->query($query_tabla);
echo "<div class='container mt-5'>";
echo "<div class='card-body'>";
echo "<div class='table-responsive'>";
echo "<table id='example' class='table table-striped table-hover table-bordered' style='width:100%;'>";
echo "<thead class='table-success'>";
echo "<tr>";
echo "<th>#</th>";
echo "<th>EMPRESA</th>";
echo "<th>NOMBRE</th>";
echo "<th>DEPARTAMENTO</th>";
echo "<th>FECHA</th>";
echo "<th>BOTON</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
if ($result->num_rows > 0) {
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        $id_usuario = $row['id_usuario'];
        $query_res = "SELECT id_pregunta, respuesta FROM respuestas WHERE id_usuario  AND encuesta_id  ORDER BY fecha_respuesta";       
        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td>{$row['empresa']}</td>";
        echo "<td>{$row['nombre_completo']}</td>";
        echo "<td>{$row['area']}</td>";
 
        $date = new DateTime($row['fecha_registro']);
        echo "<td>" . $date->format('d/m/Y H:i') . "</td>";
        $iduser = $row['id_usuario'];
        $empresa =$row['empresa'];
        $valor = $row['estado']; 
        $nombre = $row['nombre_completo'];
   

        echo '<td>';


        if ($valor == 1  ) 
        {      
        echo '<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop' . $i . '">AVISAR</button>';
            echo '<div class="modal fade" id="staticBackdrop' . $i . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel' . $i . '" aria-hidden="true">';
            echo '  <div class="modal-dialog">';
            echo '    <div class="modal-content">';
            echo '      <div class="modal-header">';
            echo '        <h1 class="modal-title fs-5" id="staticBackdropLabel' . $i . '">Notificación de registro</h1>';
            echo '        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '      </div>';
            echo '      <div class="modal-body">';
            echo "       Empresa: <div class='fw-bold'> $empresa </div>  Nombre: <div class='fw-bold'> $nombre </div><br>";
            echo '        <form action="actualizar.php" method="post">';
            echo '          <input type="hidden" name="id_usuario" value="' . $iduser . '">';
            echo '          <input type="hidden" name="valor" value="' . $valor . '">';
            echo '      </div>';
            echo '      <div class="modal-footer">';
            echo '        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>';
            echo '        <button type="submit" class="btn btn-success">Notificar</button>';
            echo '      </div>';
            echo '        </form>';
            echo '    </div>';
            echo '  </div>';
            echo '</div>';
        
        echo '</td>';
     
        echo "</tr>";
      
     } elseif ( ($valor == 3)) {

      echo '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop' . $i . '">SALIDA</button>';
      echo '<div class="modal fade" id="staticBackdrop' . $i . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel' . $i . '" aria-hidden="true">';
      echo '  <div class="modal-dialog">';
      echo '    <div class="modal-content">';
      echo '      <div class="modal-header">';
      echo "        <h1 class=\"modal-title fs-5\" id=\"staticBackdropLabel$i\">Confirmación de salida</h1>";
      echo '        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
      echo '      </div>';
      echo '      <div class="modal-body">';
      echo "       Empresa:<div class='fw-bold'>$empresa</div> Nombre:<div class='fw-bold'>$nombre</div><br>";
      echo '        <form action="actualizar.php" method="post">';
      echo '          <input type="hidden" name="id_usuario" value="' . $iduser . '">';
      echo '          <input type="hidden" name="valor" value="' . $valor . '">';
      echo '      </div>';
      echo '      <div class="modal-footer">';
      echo '        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>';
      echo '        <button type="submit" class="btn btn-success">Confirmar</button>';
      echo '      </div>';
      echo '        </form>';
      echo '    </div>';
      echo '  </div>';
      echo '</div>';
  
  echo '</td>';

  echo "</tr>";
    }

        $i++;
    }
} else {
    
    echo "<tr><td colspan='6' class='text-center'>No se encontraron registros.</td></tr>";
}
echo "<br>";    
echo "</tbody>";
echo "</table>";

echo "</div>";

echo "</div>";

echo "</div>";
echo "<br>";
$conn->close();
echo'<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  ';
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