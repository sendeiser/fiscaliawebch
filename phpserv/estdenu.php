<?php include('connect.php');
header('Content-Type: application/json');

session_start();

$user = $_SESSION['nombre_usuario'];

// Registro en auditoría: se construye más abajo con el número de expediente consultado (si existe)


$dni = isset($_POST['dni1']) ? $_POST['dni1'] : '';



if (isset($dni)) {
  $dni = mysqli_real_escape_string($conexion, $dni);
  $query = "SELECT idexpediente, dnidenunciante, denunciado, causa, numerodeexpediente, fechadeentrada, fechadesalida FROM expedientes WHERE dnidenunciante='$dni' ORDER BY fechadeentrada DESC";
  $result = mysqli_query($conexion, $query);
  $exist = $result ? mysqli_num_rows($result) : 0;
  if ($exist > 0) {
    $expedientes = [];
    $exp_num_consultado = NULL;
    while ($row = mysqli_fetch_assoc($result)) {
      if ($exp_num_consultado === NULL && !empty($row['numerodeexpediente'])) { $exp_num_consultado = $row['numerodeexpediente']; }
      $expedientes[] = $row;
    }
    echo json_encode($expedientes);
  } else {
    echo json_encode('dninoexiste');
  }
  $numExpVal = ($exist > 0 && $exp_num_consultado) ? ("'" . mysqli_real_escape_string($conexion, $exp_num_consultado) . "'") : 'NULL';
  $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente) VALUES ('expedientes', 'Consulta de estado de denuncia', '$fecha', '$hora', '$user', $numExpVal)";
  $conexion->query($sqlreg);
  if ($result) { mysqli_free_result($result); }
}
