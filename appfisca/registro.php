<?php

error_reporting (  E_ALL  ^  E_NOTICE  ^  E_DEPRECATED );
 

// 1.- IDENTIFICACION nombre de la base, del usuario, clave y servidor
            $servidor = "localhost";
            $nombreusuario = "root";
            $password = "martin/123";
            $db = "Fiscalia";
$conexion = new mysqli($servidor, $nombreusuario, $password, $db);

// 2.- CONEXION A LA BASE DE DATOS


// 3.- RECOGIDA DE DATOS DE LA APP
$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$celular=$_POST['celular'];
$correo=$_POST['correo'];
$usuario=$_POST['usuario'];
$contrasena=$_POST['contrasena'];

// 4.- FUNCION DE INSERCIÓN DE DATOS EN LA VARIABLE $sql
$sql = ("INSERT INTO Usuarios (Nombre, Apellido, Celular, Correo, Usuario, Contrasena) VALUES ('$nombre','$apellido','$celular','$correo','$usuario','$contrasena')");
 
// 5.- INSERCCION DE DATOS EN LA BD
$conexion->query($sql);
print("Datos agregados a la base.");

mysql_close($link);

?> 

