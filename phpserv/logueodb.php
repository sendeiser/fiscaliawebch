<?php

//CONEXIÓN A LA BASE DE DATOS
$hostname_db = "localhost";
$database_db = "c2191769_fisca";
$username_db = "c2191769_fisca";
$password_db = "zusuMI83fu";

//recoleccion de datos
$usuario=$_POST['usuario'];
$contrasena=$_POST['contrasena'];
//Conectar a la base de datos
$conexion = mysqli_connect($hostname_db, $username_db, $password_db);
//Seleccionar la base de datos
$conexion->set_charset('utf8');//Para las ñ y los acentos
mysqli_select_db($conexion,$database_db) or die ("Ninguna DB seleccionada");




//CONSULTA A LA BASE DE DATOS
$accion_nm="SELECT * FROM usuarios WHERE usuario='$usuario'";
$consulta_nm=mysqli_query($conexion,$accion_nm);
$ussypass=mysqli_num_rows($consulta_nm);


if ($ussypass == 1){
    $accion_nm2="SELECT * FROM usuarios WHERE usuario='$usuario' and contrasena='$contrasena'";
    $consulta_nm2=mysqli_query($conexion,$accion_nm2);
    $pssresp=mysqli_num_rows($consulta_nm2);
    if($pssresp==1){
        echo json_encode('conexion exitosa'); 
    }
    else{
        echo json_encode('contrasena incorrecta'); 
    }

}else{ 
    $accion_nm3="SELECT * FROM usuarios WHERE usuario='$usuario' or contrasena='$contrasena'";
    $consulta_nm3=mysqli_query($conexion,$accion_nm3);
    $pssresp3=mysqli_num_rows($consulta_nm3);
    
    if ($pssresp3==1) {
        echo json_encode('usuario incorrecto');
} else {
    echo json_encode('usuario y contrasena incorrectas');
}
}

if($conexion->errno) die($conexion->error);

$conexion->close();

?>