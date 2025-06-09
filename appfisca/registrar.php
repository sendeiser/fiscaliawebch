<?php

//CONEXIÓN A LA BASE DE DATOS
$hostname_db = "localhost";
$database_db = "Fiscalia";
$username_db = "root";
$password_db = "martin/123";
//Conectar a la base de datos
$conexion = mysqli_connect($hostname_db, $username_db, $password_db);
//Seleccionar la base de datos
$conexion->set_charset('utf8');//Para las ñ y los acentos
mysqli_select_db($conexion,$database_db) or die ("Ninguna DB seleccionada");

$apellido="gonzalez";//$_POST['apellido'];

//CONSULTA A LA BASE DE DATOS
$accion_nm="SELECT * FROM Usuarios WHERE Apellido='$apellido'";
$consulta_nm=mysqli_query($conexion,$accion_nm);
$datos_nm=mysqli_fetch_array();

//Cantidad de registros
$cantidad_nm=mysqli_num_rows($consulta_nm);
//Sacar datos con $datos;

$resu=mysqli_free_result($datos_nm);
$i=1;

//echo "<li>Columnas=" . count($consulta_nm->fetch_array()) . "<li>";
echo "Datos de la Consulta:  <li>$i.";

if($conexion->errno) die($conexion->error);
//Ejemplo para imprimir los datos. El bucle recorre todos los registros.

while($fila = $consulta_nm->fetch_array()){
    //echo "<li> ID: " . $fila[0] . "<li> Nombre: " . $fila[1] . "<li> Apellido: " . $fila[2] .  "<li> Celular: " . $fila[3] .  "<li> Correo: " . $fila[4] . "<li> Usuario: " . $fila[5] . "<li> Contraseña: " . $fila[6] .  "<br>";
    for ($j=0;$j<7;$j++) {
		
			$en_csv .= " ". $fila[$j].", ";
			}
		$i=$i+1;	
		$en_csv .= "<li>$i.";
		}
	print $en_csv;

    ?>