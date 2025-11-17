<?php
require 'connect.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha = date('Y-m-d');
$hora = date('H:i:s');
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $q = $conexion->query("SELECT Usuario, COUNT(*) as cnt FROM usuarios GROUP BY Usuario HAVING COUNT(*)>1");
  $dups = [];
  while($row = $q->fetch_assoc()){ $dups[] = $row; }
  http_response_code(200);
  echo json_encode(['status'=>'success','duplicates'=>$dups]);
  $conexion->close();
  exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['status'=>'error','message'=>'Método no permitido']); exit; }
$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$keep_id = isset($_POST['keep_id']) ? intval($_POST['keep_id']) : 0;
if ($usuario === '' || $keep_id <= 0) { http_response_code(400); echo json_encode(['status'=>'error','message'=>'Parámetros inválidos']); exit; }
try {
  $ids = [];
  $stmt = $conexion->prepare('SELECT idusuarios, Correo FROM usuarios WHERE Usuario = ?');
  $stmt->bind_param('s', $usuario); $stmt->execute(); $res = $stmt->get_result();
  while($row = $res->fetch_assoc()){ $ids[] = $row; }
  $stmt->close();
  $to_inactivate = array_filter($ids, function($r) use($keep_id){ return intval($r['idusuarios']) !== $keep_id; });
  foreach($to_inactivate as $r){
    $uid = intval($r['idusuarios']);
    $rnd = bin2hex(random_bytes(8));
    $conexion->query("UPDATE usuarios SET Usuario = CONCAT(Usuario, '_dup_', $uid), Contrasena = '$rnd' WHERE idusuarios = $uid");
    $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, detalles) VALUES ('usuarios','Cuenta ajustada por duplicado','$fecha','$hora','$usuario','ID ajustado: $uid')";
    $conexion->query($sqlreg);
    if (!empty($r['Correo'])) { @mail($r['Correo'], 'Cuenta ajustada por duplicado', 'Su cuenta fue ajustada por duplicado de usuario.'); }
  }
  http_response_code(200);
  echo json_encode(['status'=>'success','inactivated'=>array_map(function($r){return $r['idusuarios'];}, $to_inactivate)]);
} catch (Exception $e){
  http_response_code(500);
  error_log('Error resolviendo duplicados: '.$e->getMessage());
  echo json_encode(['status'=>'error','message'=>'Error del servidor']);
}
$conexion->close();
?>