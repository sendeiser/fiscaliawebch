<?php
header('Content-Type: application/json');
session_start();
require 'connect.php';

// Solo administrador puede eliminar
$rol = isset($_SESSION['rol']) ? strtolower(trim($_SESSION['rol'])) : null;
$tipo = isset($_SESSION['tipo']) ? strtolower(trim($_SESSION['tipo'])) : null;
if ($rol !== 'administrador' && $tipo !== 'admin') {
  http_response_code(403);
  echo json_encode(['status'=>'error','message'=>'Acceso denegado. Requiere rol de administrador']);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['status'=>'error','message'=>'Método no permitido']);
  exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
$ids = isset($data['ids']) && is_array($data['ids']) ? $data['ids'] : [];
if (empty($ids)) {
  http_response_code(400);
  echo json_encode(['status'=>'error','message'=>'Parámetros inválidos']);
  exit;
}

try {
  $placeholders = implode(',', array_fill(0, count($ids), '?'));
  $types = str_repeat('i', count($ids));
  $sql = "DELETE FROM contactos WHERE idcontacto IN ($placeholders)";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param($types, ...$ids);
  $ok = $stmt->execute();
  $stmt->close();
  if (!$ok) { throw new Exception('Error al eliminar'); }
  echo json_encode(['status'=>'success']);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['status'=>'error','message'=>'Error del servidor']);
}

$conexion->close();
?>