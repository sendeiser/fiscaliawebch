<?php
require 'connect.php';
session_start();

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];



//CONSULTA A LA BASE DE DATOS
$accion_nm = "SELECT * FROM usuarios WHERE usuario='$usuario'";
$consulta_nm = mysqli_query($conexion, $accion_nm);
$ussypass = mysqli_num_rows($consulta_nm);


if ($ussypass == 1) {
    $accion_nm2 = "SELECT * FROM usuarios WHERE usuario='$usuario' and contrasena='$contrasena'";
    $consulta_nm2 = mysqli_query($conexion, $accion_nm2);
    $pssresp = mysqli_num_rows($consulta_nm2);
    if ($pssresp == 1) {
        echo json_encode('conexion exitosa');

        $_SESSION['nombre_usuario'] = $usuario;

        $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente)
  VALUES ('Ninguna', 'Inicio de sesion', '$fecha', '$hora', '$usuario', NULL)";


        $conexion->query($sqlreg);
    } else {
        echo json_encode('contrasena incorrecta');
    }
} else {
    $accion_nm3 = "SELECT * FROM usuarios WHERE usuario='$usuario' or contrasena='$contrasena'";
    $consulta_nm3 = mysqli_query($conexion, $accion_nm3);
    $pssresp3 = mysqli_num_rows($consulta_nm3);

    if ($pssresp3 == 1) {
        echo json_encode('usuario incorrecto');
    } else {
        echo json_encode('usuario y contrasena incorrectas');
    }
}

if ($conexion->errno) die($conexion->error);

$conexion->close();
