<?php
require 'connect.php';



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