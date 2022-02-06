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
?>