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

//  3.- VISUALIZACIÓN DE LOS DATOS
$query = "SELECT * FROM comentarios ";
$result = mysql_query($query, $conexion);
if(mysql_num_rows($result)) { 
   // Escribe los resultados
   while($row = mysql_fetch_row($result))
  {
  print("<b>Fecha: </b>$row[1]<br><b>IP: </b>$row[2]<br><b>Mensajes: </b>$row[3]<br><b>Correo: </b> $row[4]<br><hr>");
  }
} else {
   // No hay resultados
   print("<b>No hay resultados.</b>");
}

mysql_close($conexion);

?>