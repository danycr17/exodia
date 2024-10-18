<?php
session_start();
include "../conexion/conexion.php";

if (mysqli_connect_error()) {
    exit('Fallo en la conexión de MySQL: ' . mysqli_connect_error());
}

if (!isset($_POST['usuario'], $_POST['password'])) {
    exit();
}

if ($stmt = $conn->prepare('SELECT id, password, perfil FROM loggin WHERE usuario = ?')) {
    $stmt->bind_param('s', $_POST['usuario']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $perfil);
        $stmt->fetch();

        if ($_POST['password'] === $password) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['usuario'];
            $_SESSION['id'] = $id;
            $_SESSION['perfil'] = $perfil;

            if ($perfil == 'SH') {
                header('Location: form.php');
            } elseif ($perfil == 'VG') {
                header('Location: vigilancia.php');
            } else {
                header('Location: index.html'); 
            }
            exit();
        } else {
            header('Location: index.html');
            exit();
        }
    } else {
        // Usuario no encontrado
        header('Location: index.html');
        exit();
    }

    $stmt->close();
} else {
    exit('Falló la preparación de la consulta: ' . $conn->error);
}
?>
