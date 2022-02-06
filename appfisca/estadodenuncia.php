<?php
// Juan Antonio Villalpando.
// KIO4.COM

 error_reporting ( 0 );

// 1.- IDENTIFICACION nombre de la base, del usuario, clave y servidor
$hostname_db = "localhost";
$database_db = "Fiscalia";
$username_db = "root";
$password_db = "martin/123";
//Conectar a la base de datos
$conexion = mysqli_connect($hostname_db, $username_db, $password_db);
$conexion->set_charset('utf8');
// 2.- CONEXION A LA BASE DE DATOS
mysqli_select_db($conexion,$database_db) or die ("Ninguna DB seleccionada");

$dni=POST_['dni'];
//  3.- VISUALIZACIÓN DE LOS DATOS
$query = "SELECT * FROM expedientes WHERE dnidenunciante='$dni'";
$result = mysqli_query($conexion, $query);
//$array=mysqli_fetch_array($result); 
   
while($row = $result->fetch_array() ) { //este while me direcciona al ultimo elemento de la ultimo array(fila)
  $last=end($row);
 }
 
if ($last==NULL) {
  echo "Su denuncia esta en proceso de salida";
} else {
  echo "Su denuncia ya se proceso en Fiscalia y paso al Juzgado el dia: ".$last;
}

mysql_close($conexion);

?>