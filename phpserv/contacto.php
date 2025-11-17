<?php
include('connect.php');
header('Content-Type: application/json');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
  exit;
}

$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
$asunto = isset($_POST['asunto']) ? trim($_POST['asunto']) : '';
$mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';
$privacidad = isset($_POST['privacidad']) ? $_POST['privacidad'] : '';

if ($nombre === '' || $email === '' || $asunto === '' || $mensaje === '' || !$privacidad) {
  http_response_code(400);
  echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
  exit;
}

$conexion->query("CREATE TABLE IF NOT EXISTS contactos (
  idcontacto int NOT NULL AUTO_INCREMENT,
  nombre varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  email varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  telefono varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  asunto varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  mensaje text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  fecha varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  hora varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  estado ENUM('leido','no_leido') NOT NULL DEFAULT 'no_leido',
  PRIMARY KEY (idcontacto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci");

$stmt = $conexion->prepare('INSERT INTO contactos (nombre, email, telefono, asunto, mensaje, fecha, hora, estado) VALUES (?, ?, ?, ?, ?, ?, ?, "no_leido")');
$stmt->bind_param('sssssss', $nombre, $email, $telefono, $asunto, $mensaje, $fecha, $hora);
$ok = $stmt->execute();

if ($ok) {
  $user = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'anonimo';
  $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario) VALUES ('contactos', 'Nuevo mensaje de contacto', '$fecha', '$hora', '$user')";
  $conexion->query($sqlreg);
  echo json_encode(['status' => 'success']);
} else {
  http_response_code(500);
  echo json_encode(['status' => 'error', 'message' => $conexion->error]);
}

$stmt->close();
$conexion->close();