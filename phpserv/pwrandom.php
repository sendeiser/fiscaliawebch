<?php
header('Content-Type: application/json');
session_start();
$rolSesion = isset($_SESSION['rol']) ? strtolower(trim($_SESSION['rol'])) : null;
$tipoSesion = isset($_SESSION['tipo']) ? strtolower(trim($_SESSION['tipo'])) : null;
if ($rolSesion !== 'administrador' && $tipoSesion !== 'admin') {
  http_response_code(403);
  echo json_encode(['status'=>'error','message'=>'Acceso denegado. Se requiere rol de administrador.']);
  exit;
}

require 'connect.php';
$conexion->set_charset('utf8');

// Asegurar existencia de la tabla
$sqlCreate = "CREATE TABLE IF NOT EXISTS pwrandom (
  id INT NOT NULL AUTO_INCREMENT,
  password_plain VARCHAR(255) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  usuario VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci";
$conexion->query($sqlCreate);

$method = $_SERVER['REQUEST_METHOD'];

function generateHashToken($length = 64) {
  $length = max(32, min(64, intval($length)));
  if ($length >= 64) { return bin2hex(random_bytes(32)); }
  return bin2hex(random_bytes(16));
}

if ($method === 'POST') {
  $length = 64;
  if (isset($_POST['length'])) { $length = intval($_POST['length']); }
  $raw = file_get_contents('php://input');
  if ($raw) {
    $json = json_decode($raw, true);
    if (is_array($json) && isset($json['length'])) { $length = intval($json['length']); }
  }
  $pwd = generateHashToken($length);
  $hash = password_hash($pwd, PASSWORD_BCRYPT);
  $usuario = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'admin';
  $now = date('Y-m-d H:i:s');
  $stmt = $conexion->prepare('INSERT INTO pwrandom (password_plain, password_hash, usuario, created_at) VALUES (?,?,?,?)');
  $stmt->bind_param('ssss', $pwd, $hash, $usuario, $now);
  if (!$stmt->execute()) {
    echo json_encode(['status'=>'error','message'=>'No se pudo guardar la contraseña']);
    exit;
  }
  $id = $stmt->insert_id; $stmt->close();
  echo json_encode(['status'=>'success','data'=>['id'=>$id,'password'=>$pwd,'length'=>$length]]);
  $conexion->close();
  exit;
}

if ($method === 'GET') {
  $limit = isset($_GET['limit']) ? max(1, min(50, intval($_GET['limit']))) : 10;
  $result = $conexion->query('SELECT id, password_plain, usuario, created_at FROM pwrandom ORDER BY id DESC LIMIT '.intval($limit));
  $rows = [];
  if ($result) { while ($r = $result->fetch_assoc()) { $rows[] = $r; } }
  echo json_encode(['status'=>'success','data'=>['registros'=>$rows]]);
  $conexion->close();
  exit;
}

if ($method === 'DELETE') {
  $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
  if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>'ID inválido']);
    $conexion->close();
    exit;
  }
  $stmt = $conexion->prepare('DELETE FROM pwrandom WHERE id = ?');
  $stmt->bind_param('i', $id);
  if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>'No se pudo eliminar']);
    $stmt->close(); $conexion->close();
    exit;
  }
  $stmt->close();
  echo json_encode(['status'=>'success']);
  $conexion->close();
  exit;
}

http_response_code(405);
echo json_encode(['status'=>'error','message'=>'Método no permitido']);
?>
