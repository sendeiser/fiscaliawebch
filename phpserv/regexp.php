<?php       //CONEXIÓN A LA BASE DE DATOS
$hostname_db = "localhost";
$database_db = "fiscaliach";
$username_db = "root";
$password_db = "";

$conexion = mysqli_connect($hostname_db, $username_db, $password_db);
//Seleccionar la base de datos
$conexion->set_charset('utf8'); //Para las ñ y los acentos
mysqli_select_db($conexion, $database_db) or die("Ninguna DB seleccionada");






if (isset($_POST['dni'])) {

  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $dni = $_POST['dni'];
  
  $fechadesalida = $_POST['fechadesalida'];
  $fechadeentrada = $_POST['fechadeentrada'];
  $denunciado = $_POST['denunciado'];
  $comisaria = $_POST['comisaria'];
  $fojas = $_POST['fojas'];
  $librodeactas = $_POST['librodeactas'];
  $nroexpediente = $_POST['nroexpediente'];
  $causa = $_POST['causa'];
  $medida = $_POST['medida'];
  
  
  $sql = "INSERT INTO expedientes (causa, medida, fechadeentrada, fojas, librodeactas, codigocomisaria, numerodeexpediente, dnidenunciante,denunciado) VALUES ('$causa','$medida','$fechadeentrada','$fojas','$librodeactas','$comisaria','$nroexpediente','$dni','$denunciado')";
  
  $sql2 = "INSERT INTO personas1 (dnidenunciante, nombre, apellido) VALUE ('$dni','$nombre','$apellido')";
  
  $pregunta = "SELECT * FROM personas1 WHERE dnidenunciante='$dni'";
  $consulta = mysqli_query($conexion, $pregunta);
  $resp = mysqli_num_rows($consulta);

  if ($resp == 0) {

    if ($conexion->query($sql) == true and $conexion->query($sql2) == true) {

      echo json_encode('personanueva');
    } else {
      echo json_encode('Error al insertar datos: ' . $conexion->error);
    }
  } else {

    if ($conexion->query($sql) == true) {

      echo json_encode('personaregistrada');
    } else {
      die("Error al insertar datos: " . $conexion->error);
    }
  }
}
///////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['dni1'])) {
  $dni_sal = $_POST['dni1'];
  $salida = $_POST['fecha_salida'];

  $sql4 = "SELECT * FROM expedientes WHERE dnidenunciante='$dni_sal'";
  $consulta1 = mysqli_query($conexion, $sql4);
  $exist = mysqli_num_rows($consulta1);

  if ($exist > 0) {

    $sql3 = "UPDATE expedientes SET  fechadesalida='$salida' where dnidenunciante='$dni_sal'";

    if ($conexion->query($sql3) == true) {
        echo json_encode('exitoso');
    } else {
        die("Error al insertar datos: " . $conexion->error);
    }
  } else {
      echo json_encode('dninoexiste');
  }
}
