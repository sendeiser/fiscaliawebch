<?php
require 'connect.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'GET') { http_response_code(405); echo json_encode(['status'=>'error','message'=>'Método no permitido']); exit; }
$usuario = isset($_GET['usuario']) ? trim($_GET['usuario']) : '';
$correo = isset($_GET['correo']) ? trim($_GET['correo']) : '';
$emailAvailable = true; $usernameAvailable = true;
try {
  if ($correo !== '') {
    $s = $conexion->prepare('SELECT idusuarios FROM usuarios WHERE Correo = ? LIMIT 1');
    $s->bind_param('s', $correo); $s->execute(); $s->store_result(); $emailAvailable = ($s->num_rows === 0); $s->close();
  }
  if ($usuario !== '') {
    $s2 = $conexion->prepare('SELECT idusuarios FROM usuarios WHERE Usuario = ? LIMIT 1');
    $s2->bind_param('s', $usuario); $s2->execute(); $s2->store_result(); $usernameAvailable = ($s2->num_rows === 0); $s2->close();
  }
  http_response_code(200);
  echo json_encode(['status'=>'success','emailAvailable'=>$emailAvailable,'usernameAvailable'=>$usernameAvailable]);
} catch(Exception $e){
  http_response_code(500);
  error_log('Error check availability: '.$e->getMessage());
  echo json_encode(['status'=>'error','message'=>'Error del servidor']);
}
$conexion->close();
?>