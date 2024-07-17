<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de la consulta</title>
    <style>
        /* Estilo para las líneas de la tabla */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Estilo para la barra de navegación */
        .navbar {
            background-color: #e3f2fd;
            padding: 10px;
        }
        .navbar a {
            text-decoration: none;
            color: #333;
            margin-right: 20px;
        }
        .navbar a:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <a href="#">Ver formularios</a>
    <a href="#">Crear formularios</a>
    <a href="#">Ver preguntas</a>
    <a href="#">Crear preguntas</a>
</nav>
<br>

<?php
// Conexión a la base de datos (reemplaza con tus propios datos)
include "../conexion/conexion.php";

// Consulta para obtener los datos
$q = "SELECT * FROM `form`";
$r = mysqli_query($conn, $q);

echo "<table>";
echo "<tr>";
echo "<th>ID Encuesta</th>";
echo "<th>Nombre encuesta</th>";
echo "<th>Fecha de Registro</th>";
echo "<th>Estatus</th>";
echo "</tr>";

$count = 0;
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    echo "<tr>";
    echo "<td>{$row['id_encuesta']}</td>";
    echo "<td>{$row['nombre']}</td>";
    echo "<td>{$row['fecha_reg']}</td>";
    echo "<td>{$row['estatus']}</td>";
    echo "</tr>";
    $count++;
}
echo "</table>";

$conn->close();
?>
</body>
</html>
