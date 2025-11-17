<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/connect.php';

$rolSesion = isset($_SESSION['rol']) ? strtolower(trim($_SESSION['rol'])) : null;
$tipoSesion = isset($_SESSION['tipo']) ? strtolower(trim($_SESSION['tipo'])) : null;
if ($rolSesion !== 'administrador' && $tipoSesion !== 'admin') { http_response_code(403); echo json_encode(['status'=>'error','message'=>'Acceso denegado']); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['status'=>'error','message'=>'Método no permitido']); exit; }

$payload = json_decode(file_get_contents('php://input'), true);
$ids = isset($payload['ids']) && is_array($payload['ids']) ? array_filter($payload['ids'], function($v){ return is_numeric($v); }) : [];
if (empty($ids)) { http_response_code(400); echo json_encode(['status'=>'error','message'=>'Parámetros inválidos']); exit; }

try {
  $placeholders = implode(',', array_fill(0, count($ids), '?'));
  $sql = "DELETE FROM contactos WHERE idcontacto IN ($placeholders)";
  $stmt = $conexion->prepare($sql);
  $types = str_repeat('i', count($ids));
  $params = array_map('intval', $ids);
  $stmt->bind_param($types, ...$params);
  $ok = $stmt->execute();
  $affected = $stmt->affected_rows;
  $stmt->close();
  if (!$ok) { http_response_code(500); echo json_encode(['status'=>'error','message'=>'Error al eliminar']); exit; }
  echo json_encode(['status'=>'success','deleted'=>$affected]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['status'=>'error','message'=>'Error del servidor']);
}
$conexion->close();
?>