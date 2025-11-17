<?php
header('Content-Type: application/json');
require 'connect.php';
$conexion->set_charset('utf8');

$pwd = isset($_GET['pwd']) ? trim($_GET['pwd']) : '';
if ($pwd === '') {
  http_response_code(400);
  echo json_encode(['status'=>'error','message'=>'Parámetro faltante']);
  exit;
}

$stmt = $conexion->prepare('SELECT id FROM pwrandom WHERE password_plain = ? LIMIT 1');
$stmt->bind_param('s', $pwd);
$stmt->execute();
$stmt->store_result();
$exists = $stmt->num_rows > 0;
$stmt->close();
$conexion->close();
echo json_encode(['status'=>'success','exists'=>$exists]);
?>