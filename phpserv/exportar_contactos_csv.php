<?php
session_start();
require 'connect.php';

// Permitir exportar a usuarios autenticados
if (!isset($_SESSION['nombre_usuario']) || empty($_SESSION['nombre_usuario'])) {
  header('Content-Type: application/json');
  http_response_code(401);
  echo json_encode(['status'=>'error','message'=>'No autorizado']);
  exit;
}

$conexion->set_charset('utf8');

$where = [];
$params = [];
$types = '';

if (isset($_GET['date_from']) && $_GET['date_from'] !== '') { $where[] = 'fecha >= ?'; $params[] = $_GET['date_from']; $types .= 's'; }
if (isset($_GET['date_to']) && $_GET['date_to'] !== '') { $where[] = 'fecha <= ?'; $params[] = $_GET['date_to']; $types .= 's'; }
if (isset($_GET['estado']) && $_GET['estado'] !== '') { $where[] = 'estado = ?'; $params[] = $_GET['estado']; $types .= 's'; }
if (isset($_GET['q']) && $_GET['q'] !== '') {
  $like = '%' . $_GET['q'] . '%';
  $where[] = '(nombre LIKE ? OR email LIKE ? OR asunto LIKE ? OR mensaje LIKE ?)';
  $params[] = $like; $params[] = $like; $params[] = $like; $params[] = $like; $types .= 'ssss';
}

$sql = 'SELECT idcontacto, nombre, email, telefono, asunto, mensaje, fecha, hora, estado FROM contactos';
if (!empty($where)) { $sql .= ' WHERE ' . implode(' AND ', $where); }
$sql .= ' ORDER BY fecha DESC, hora DESC';

$stmt = $conexion->prepare($sql);
if (!empty($params)) { $stmt->bind_param($types, ...$params); }
$stmt->execute();
$result = $stmt->get_result();

$filename = 'contactos_export_' . date('Ymd_His') . '.csv';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

$out = fopen('php://output', 'w');
// Encabezados
fputcsv($out, ['ID','Nombre','Email','Telefono','Asunto','Mensaje','Fecha','Hora','Estado']);
while ($r = $result->fetch_assoc()) {
  fputcsv($out, [$r['idcontacto'],$r['nombre'],$r['email'],$r['telefono'],$r['asunto'],$r['mensaje'],$r['fecha'],$r['hora'],$r['estado']]);
}
fclose($out);

$stmt->close();
$conexion->close();
exit;
?>