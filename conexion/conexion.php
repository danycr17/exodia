<?php

$servername = "localhost";  
$username = "root";   
$password = ""; 
$dbname = "registros"; 


$conn = new mysqli($servername, $username, $password, $dbname);

// conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
} 





?>