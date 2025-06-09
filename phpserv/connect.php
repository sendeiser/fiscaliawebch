<?php

date_default_timezone_set("America/Argentina/Buenos_Aires");
setlocale(LC_TIME, 'es_RA.UTF-8','esp');



$fecha = date("Y-m-d"); // Genera la fecha actual en formato "YYYY-MM-DD"
$hora = date("H:i:s"); // Genera la hora actual en formato "HH:MM:SS"



//CONEXIÓN A LA BASE DE DATOS
// 1.- IDENTIFICACION nombre de la base, del usuario, clave y servidor
$servidor = "localhost";
$nombreusuario = "root";
$password = "";
$db = "fiscaliach";
$conexion = new mysqli($servidor, $nombreusuario, $password, $db);
$conexion->set_charset('utf8');
