<?php
//CONEXIÓN A LA BASE DE DATOS
$hostname_db = "localhost";
$database_db = "c2191769_fisca";
$username_db = "c2191769_fisca";
$password_db = "zusuMI83fu";

$conexion = mysqli_connect($hostname_db, $username_db, $password_db);
//Seleccionar la base de datos
$conexion->set_charset('utf8');//Para las ñ y los acentos
mysqli_select_db($conexion,$database_db) or die ("Ninguna DB seleccionada");



  $nombre=$_POST['nombre']; $apellido=$_POST['apellido']; $celular=$_POST['celular']; $correo=$_POST['correo'];
  $usuario=$_POST['usuario']; $contrasena=$_POST['contrasena'];

  $sql = "INSERT INTO usuarios (Nombre, Apellido, Celular, Correo, Usuario, Contrasena) VALUES ('$nombre','$apellido','$celular','$correo','$usuario','$contrasena')";
  
  if(isset($nombre)){
 if($conexion->query($sql) === true){
                   echo json_encode('exitoso');
                }else{
                  json_encode('Error al insertar datos: '.$conexion->error);
                }
                
   }



$conexion->close();

?>