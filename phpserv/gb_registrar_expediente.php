<?php
header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['nombre_usuario']) || empty($_SESSION['nombre_usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}
require 'connect.php';
$usuario = $_SESSION['nombre_usuario'];
$fecha = date('Y-m-d');
$hora = date('H:i:s');
$conexion->set_charset('utf8');

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) { $data = $_POST; }

$dni = isset($data['dni']) ? trim($data['dni']) : '';
$nombre = isset($data['nombre']) ? trim($data['nombre']) : '';
$apellido = isset($data['apellido']) ? trim($data['apellido']) : '';
$denunciado = isset($data['denunciado']) ? trim($data['denunciado']) : '';
$causa = isset($data['causa']) ? trim($data['causa']) : '';
$medida = isset($data['medida']) ? trim($data['medida']) : '';
$fojas = isset($data['fojas']) ? intval($data['fojas']) : null;
$libro = isset($data['librodeactas']) ? intval($data['librodeactas']) : null;
$comisaria = isset($data['codigocomisaria']) ? intval($data['codigocomisaria']) : (isset($data['comisaria']) ? intval($data['comisaria']) : 0);
$nroexp = isset($data['numerodeexpediente']) ? trim($data['numerodeexpediente']) : (isset($data['nroexpediente']) ? trim($data['nroexpediente']) : '');
$numexpinstr = isset($data['numexpinstru']) ? trim($data['numexpinstru']) : null;
$fechaent = isset($data['fechadeentrada']) ? trim($data['fechadeentrada']) : date('Y-m-d');

if ($dni === '' || $nombre === '' || $apellido === '' || $denunciado === '' || $causa === '' || $medida === '' || $comisaria === '' || $nroexp === '') {
    echo json_encode(['status'=>'error','message'=>'Campos requeridos faltantes']);
    exit;
}

$conexion->begin_transaction();

$stmtExp = $conexion->prepare('INSERT INTO expedientes (causa, medida, fechadeentrada, fojas, librodeactas, codigocomisaria, numerodeexpediente, dnidenunciante, denunciado, numexpinstru) VALUES (?,?,?,?,?,?,?,?,?,?)');
$stmtExp->bind_param('sssiiisisi', $causa, $medida, $fechaent, $fojas, $libro, $comisaria, $nroexp, $dni, $denunciado, $numexpinstr);
if (!$stmtExp->execute()) { $conexion->rollback(); echo json_encode(['status'=>'error','message'=>$stmtExp->error?:'Error expediente']); exit; }
$idexp = $stmtExp->insert_id; $stmtExp->close();

$stmtp = $conexion->prepare('SELECT dnidenunciante FROM personas1 WHERE dnidenunciante = ?');
$stmtp->bind_param('i', $dni); $stmtp->execute(); $rp = $stmtp->get_result(); $exists = ($rp && $rp->num_rows > 0);
$stmtp->close();

if (!$exists) {
    $stmtInsP = $conexion->prepare('INSERT INTO personas1 (dnidenunciante, nombre, apellido) VALUES (?,?,?)');
    $stmtInsP->bind_param('iss', $dni, $nombre, $apellido);
    if (!$stmtInsP->execute()) { $conexion->rollback(); echo json_encode(['status'=>'error','message'=>$stmtInsP->error?:'Error personas']); exit; }
    $stmtInsP->close();
} else {
    $stmtUpdP = $conexion->prepare('UPDATE personas1 SET nombre = ?, apellido = ? WHERE dnidenunciante = ?');
    $stmtUpdP->bind_param('ssi', $nombre, $apellido, $dni);
    if (!$stmtUpdP->execute()) { $conexion->rollback(); echo json_encode(['status'=>'error','message'=>$stmtUpdP->error?:'Error personas']); exit; }
    $stmtUpdP->close();
}

$conexion->commit();

$sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente, dni) VALUES ('expedientes', 'Nuevo Registro de expediente', '$fecha', '$hora', '$usuario', '$nroexp', '$dni')";
$conexion->query($sqlreg);

echo json_encode(['status'=>'success','data'=>['idexpediente'=>$idexp]]);
$conexion->close();