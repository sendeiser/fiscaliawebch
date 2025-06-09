<?php
include('connect.php');

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Consulta para verificar si es un usuario administrador
$query = "SELECT * FROM usuarios WHERE usuario='$usuario' AND contrasena='$contrasena'";
$result = mysqli_query($conexion, $query);

if(mysqli_num_rows($result) > 0) {
    echo json_encode('autorizado');
} else {
    echo json_encode('no_autorizado');
}
?>