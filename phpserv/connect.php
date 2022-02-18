<?php

//CONEXIÓN A LA BASE DE DATOS
// 1.- IDENTIFICACION nombre de la base, del usuario, clave y servidor
$servidor = "localhost";
$nombreusuario = "root";
$password = "";
$db = "fiscaliach";
$conexion = new mysqli($servidor, $nombreusuario, $password, $db);
$conexion->set_charset('utf8');
