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

$dni = isset($data['dni']) ? trim($data['dni']) : (isset($data['dni1']) ? trim($data['dni1']) : '');
$fecha_salida = isset($data['fecha_salida']) ? trim($data['fecha_salida']) : date('Y-m-d');
if ($dni === '') { echo json_encode(['status'=>'error','message'=>'DNI requerido']); exit; }

$stmt = $conexion->prepare('SELECT idexpediente, numerodeexpediente, fechadesalida FROM expedientes WHERE dnidenunciante = ? ORDER BY idexpediente DESC LIMIT 1');
$stmt->bind_param('i', $dni); $stmt->execute(); $res = $stmt->get_result();
if (!$res || $res->num_rows === 0) { echo json_encode(['status'=>'error','message'=>'No existe expediente para DNI']); exit; }
$row = $res->fetch_assoc(); $idexp = intval($row['idexpediente']); $nroexp = $row['numerodeexpediente'];
$ya_salida = isset($row['fechadesalida']) && trim($row['fechadesalida']) !== '';
$stmt->close();

if ($ya_salida) {
    echo json_encode(['status'=>'error','message'=>'El expediente ya tiene registrada la fecha de salida','data'=>['idexpediente'=>$idexp,'fecha_salida'=>$row['fechadesalida']]]);
    $conexion->close();
    exit;
}

$stmtUpd = $conexion->prepare('UPDATE expedientes SET fechadesalida = ? WHERE idexpediente = ?');
$stmtUpd->bind_param('si', $fecha_salida, $idexp);
if (!$stmtUpd->execute()) { echo json_encode(['status'=>'error','message'=>'Error al actualizar salida']); exit; }
$stmtUpd->close();

$sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, num_expediente, dni) VALUES ('expedientes', 'Se registro una nueva fecha de salida', '$fecha', '$hora', '$usuario', '$nroexp', '$dni')";
$conexion->query($sqlreg);

echo json_encode(['status'=>'success','data'=>['idexpediente'=>$idexp,'fecha_salida'=>$fecha_salida]]);
$conexion->close();
