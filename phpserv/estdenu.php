<?php include('connect.php');

session_start();

$user = $_SESSION['nombre_usuario'];

$sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente)
  VALUES ('Ninguna', 'Consulta de estado de denuncia', '$fecha', '$hora', '$user', NULL)";


$dni = $_POST['dni1'];



if (isset($dni)) {
  $query = "SELECT * FROM expedientes WHERE dnidenunciante='$dni'";
  $result = mysqli_query($conexion, $query);

  $exist = mysqli_num_rows($result);

  if ($exist > 0) {

    while ($row = $result->fetch_array()) {
      $last = end($row);
    }

    if ($last == NULL) {
      echo json_encode('noprocesada');
    } else {

      echo json_encode($last);
    }
  } else {
    echo json_encode('dninoexiste');
  }
  $conexion->query($sqlreg);  //registro el uso de la consulta del estado de la denuncia realizada por el usario 
}

mysqli_free_result($result);
