<?php       //CONEXIÓN A LA BASE DE DATOS
require 'connect.php';

session_start();

$user = $_SESSION['nombre_usuario'];



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

  $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente)
  VALUES ('expedientes', 'Nuevo Registro de expediente', '$fecha', '$hora', '$user', '$nroexpediente');";


  $sql = "INSERT INTO expedientes (causa, medida, fechadeentrada, fojas, librodeactas, codigocomisaria, numerodeexpediente, dnidenunciante,denunciado) VALUES ('$causa','$medida','$fechadeentrada','$fojas','$librodeactas','$comisaria','$nroexpediente','$dni','$denunciado')";

  $sql2 = "INSERT INTO personas1 (dnidenunciante, nombre, apellido) VALUE ('$dni','$nombre','$apellido')";



  $pregunta = "SELECT * FROM personas1 WHERE dnidenunciante='$dni'";
  $consulta = mysqli_query($conexion, $pregunta);
  $resp = mysqli_num_rows($consulta);

  if ($resp == 0) {

    if ($conexion->query($sql) == true and $conexion->query($sql2) == true) {
      if ($conexion->query($sqlreg) == true) {

        echo json_encode('personanueva');
      } else {
        echo json_encode('Error al insertar EL REGISTRO AUDITORIA: ' . $conexion->error);
      }
    } else {
      echo json_encode('Error al insertar datos: ' . $conexion->error);
    }
  } else {

    if ($conexion->query($sql) == true and $conexion->query($sqlregis) == true) {

      echo json_encode('personaregistrada');
    } else {
      die("Error al insertar datos: " . $conexion->error);
    }
  }
}
///////////////////////////////////////////////////////////////////////////////////////////////
////Registro de salida del expediente


if (isset($_POST['dni1'])) {
  $dni_sal = $_POST['dni1'];
  $salida = $_POST['fecha_salida'];
  
  $nroexpsql = "SELECT numerodeexpediente FROM expedientes WHERE dnidenunciante = '$dni_sal'";
  $result = mysqli_query($conexion, $nroexpsql);
  
  if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $nroexpediente1 = $row['numerodeexpediente'];
      
      $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente) VALUES ('expedientes', 'Se registro una nueva fecha de salida', '$fecha', '$hora', '$user', '$nroexpediente1')";
      $sql4 = "SELECT * FROM expedientes WHERE dnidenunciante='$dni_sal'";
      $consulta1 = mysqli_query($conexion, $sql4);
      $exist = mysqli_num_rows($consulta1);
      
      if ($exist > 0) {
          $sql3 = "UPDATE expedientes SET fechadesalida='$salida' WHERE dnidenunciante='$dni_sal'";
          
          if ($conexion->query($sql3) === true) {
              if ($conexion->query($sqlreg) === true) {
                  echo json_encode('exitoso');
              } else {
                  echo json_encode('Error al insertar EL REGISTRO AUDITORIA: ' . $conexion->error);
              }
          } else {
              echo json_encode('Error al insertar datos: ' . $conexion->error);
          }
      } else {
          echo json_encode('dninoexiste');
      }
  } else {
      echo json_encode('Error al obtener el número de expediente');
  }
}


/* if (isset($_POST['dni1'])) {

  $dni_sal = $_POST['dni1'];
  $salida = $_POST['fecha_salida'];

  $nroexpsql = "SELECT numerodeexpediente FROM expedientes WHERE dnidenunciante = '$dni_sal'";
  $nroexpediente1 = mysqli_query($conexion, $nroexpsql);


  $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente)
  VALUES ('expedientes', 'Se registro una nueva fecha de salida', '$fecha', '$hora', '$user', '$nroexpediente1')";


  $sql4 = "SELECT * FROM expedientes WHERE dnidenunciante='$dni_sal'";
  $consulta1 = mysqli_query($conexion, $sql4);
  $exist = mysqli_num_rows($consulta1);

  if ($exist > 0) {

    $sql3 = "UPDATE expedientes SET  fechadesalida='$salida' where dnidenunciante='$dni_sal'";

    if ($conexion->query($sql3) == true) {
      if ($conexion->query($sqlreg) == true) {

        echo json_encode('exitoso');
      } else {
        echo json_encode('Error al insertar EL REGISTRO AUDITORIA: ' . $conexion->error);
      }
    } else {
      die("Error al insertar datos: " . $conexion->error);
    }
  } else {
    echo json_encode('dninoexiste');
  }
} */
