<?php

$servidor = "45.236.131.227";
$nombreusuario = "root";
$password = "martin/123";
$db = "Fiscalia";
$conexion = new mysqli($servidor, $nombreusuario, $password, $db);



/*if(isset($_POST['cantidad'])=="cantidad"){
$sql = "SELECT * FROM noticias";
$consulta=mysqli_query($conexion, $sql);
$resp=mysqli_num_rows($consulta);
echo json_encode($resp);
 }

 if($_POST['datos']=="datos"){*/


    $sql = "SELECT * FROM noticias";
    $consulta=mysqli_query($conexion, $sql);



   
   while($fila = mysqli_fetch_assoc($consulta)){
    $datos[]=$fila;
    }
  
 echo  json_encode($datos);
   
// }


?>