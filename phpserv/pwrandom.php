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

function generatePassword($length = 12) {
  $length = max(8, min(64, intval($length)));
  $lower = 'abcdefghjkmnpqrstuvwxyz';
  $upper = 'ABCDEFGHJKMNPQRSTUVWXYZ';
  $digits = '23456789';
  $symbols = '@#$%&*+-_=';
  $all = $lower.$upper.$digits.$symbols;
  $password = '';
  $password .= $lower[random_int(0, strlen($lower)-1)];
  $password .= $upper[random_int(0, strlen($upper)-1)];
  $password .= $digits[random_int(0, strlen($digits)-1)];
  $password .= $symbols[random_int(0, strlen($symbols)-1)];
  for ($i = 4; $i < $length; $i++) {
    $password .= $all[random_int(0, strlen($all)-1)];
  }
  $chars = str_split($password);
  for ($i = count($chars)-1; $i > 0; $i--) {
    $j = random_int(0, $i);
    [$chars[$i], $chars[$j]] = [$chars[$j], $chars[$i]];
  }
  return implode('', $chars);
}

if ($method === 'POST') {
  $length = 12;
  if (isset($_POST['length'])) { $length = intval($_POST['length']); }
  $raw = file_get_contents('php://input');
  if ($raw) {
    $json = json_decode($raw, true);
    if (is_array($json) && isset($json['length'])) { $length = intval($json['length']); }
  }
  $pwd = generatePassword($length);
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

http_response_code(405);
echo json_encode(['status'=>'error','message'=>'Método no permitido']);
?>