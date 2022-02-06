<?php

            $servidor = "localhost";
            $nombreusuario = "root";
            $password = "martin/123";
            $db = "Fiscalia";

            $apellido=$_POST['apellido'];
            $nombre=$_POST['nombre'];
  
try{
  $conexion = new mysqli($servidor, $nombreusuario, $password, $db);
  $conexion->set_charset('utf8');
  echo "<h3>DATOS DE USUARIO</h3><ol>";
  foreach($conexion->query("SELECT * FROM Usuarios WHERE Apellido='$apellido' and Nombre='$nombre'") as $row ) {
    print "Nombre: <ol>" . $row["Nombre"] . "Apellido: " . $row["Apellido"] . "</ol>Correo: " . $row["Correo"] . "<li>Celular: " . $row["Celular"] . "<li>Usuario: " . $row["usuario"] . "<li>Contraseña: " . $row["contrasena"] ."";
  }
  echo "</ol>";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
	//($conexion->query("SELECT * FROM Usuarios WHERE Apellido='rearte' and Nombre='rodrigo'"
}
//<li>Nombre: 
?>