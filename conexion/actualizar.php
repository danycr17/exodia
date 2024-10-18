
<?php
include "../conexion/conexion.php";

if (isset($_POST['id_usuario']) && isset($_POST['valor'])) {
    $iduser = $_POST['id_usuario'];
    $valor = $_POST['valor'];
    echo $iduser;

    if ($valor == 1) {
        $valor = 2;
        $query = "UPDATE usuarios_registro SET estado = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $valor, $iduser);

        if ($stmt->execute()) {
            echo "Datos actualizados correctamente";
            echo "<br>";
            echo "El valor es " . $valor;
        } else {
            echo "Error al actualizar los datos: " . $stmt->error;
        }

        $stmt->close();
    }elseif ($valor == 3) {
        $valor = 4;
       
        
        $query = "UPDATE usuarios_registro SET estado = ?, fecha_salida = NOW() WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $valor, $iduser);

        if ($stmt->execute()) {
            echo "Datos actualizados correctamente";
            echo "<br>";
            echo "El valor es " . $valor;
        } else {
            echo "Error al actualizar los datos: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "No se recibieron los datos necesarios";
    }
} 

$conn->close();
header('Location: tabla.php');
?>



