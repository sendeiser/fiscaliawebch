<?php
require 'connect.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['status'=>'error','message'=>'Método no permitido']); exit; }
function index_exists($conn, $table, $index){
  $res = $conn->query('SELECT DATABASE() AS db');
  $row = $res->fetch_assoc();
  $schema = $row['db'];
  $stmt = $conn->prepare('SELECT COUNT(1) FROM INFORMATION_SCHEMA.STATISTICS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND INDEX_NAME = ?');
  $stmt->bind_param('sss', $schema, $table, $index);
  $stmt->execute();
  $stmt->bind_result($cnt);
  $stmt->fetch();
  $stmt->close();
  return $cnt>0;
}
$res = [];
try{
  if (!index_exists($conexion, 'usuarios', 'uniq_usuarios_correo')) {
    $conexion->query('ALTER TABLE usuarios ADD UNIQUE INDEX uniq_usuarios_correo (Correo)');
    $res[] = 'correo_ok';
  }
  if (!index_exists($conexion, 'usuarios', 'uniq_usuarios_usuario')) {
    $conexion->query('ALTER TABLE usuarios ADD UNIQUE INDEX uniq_usuarios_usuario (Usuario)');
    $res[] = 'usuario_ok';
  }
  http_response_code(200);
  echo json_encode(['status'=>'success','applied'=>$res]);
}catch(Exception $e){
  http_response_code(500);
  error_log('Error constraints: '.$e->getMessage());
  echo json_encode(['status'=>'error','message'=>'Error al aplicar restricciones']);
}
$conexion->close();
?>