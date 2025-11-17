<?php
session_start();
require_once __DIR__ . '/connect.php';

$rolSesion = isset($_SESSION['rol']) ? strtolower(trim($_SESSION['rol'])) : null;
$tipoSesion = isset($_SESSION['tipo']) ? strtolower(trim($_SESSION['tipo'])) : null;
$permitido = ($rolSesion === 'administrador' || $tipoSesion === 'admin' || $rolSesion === 'usuario');
if (!$permitido) { http_response_code(403); echo 'Acceso denegado'; exit; }

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$items = isset($_GET['items_per_page']) ? max(1, min(1000, intval($_GET['items_per_page'])) ) : 1000;
$date_from = isset($_GET['date_from']) ? trim($_GET['date_from']) : '';
$date_to = isset($_GET['date_to']) ? trim($_GET['date_to']) : '';
$estado = isset($_GET['estado']) ? trim($_GET['estado']) : '';
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$where = [];
$params = [];
$types = '';
if ($date_from !== '') { $where[] = 'fecha >= ?'; $params[] = $date_from; $types .= 's'; }
if ($date_to !== '') { $where[] = 'fecha <= ?'; $params[] = $date_to; $types .= 's'; }
if ($estado !== '') { $where[] = 'estado = ?'; $params[] = $estado; $types .= 's'; }
if ($q !== '') { $where[] = '(nombre LIKE ? OR email LIKE ? OR asunto LIKE ? OR mensaje LIKE ?)'; $like = '%'.$q.'%'; $params[] = $like; $params[] = $like; $params[] = $like; $params[] = $like; $types .= 'ssss'; }
$whereSql = count($where) ? (' WHERE ' . implode(' AND ', $where)) : '';

$offset = ($page - 1) * $items;
$sql = 'SELECT idcontacto, nombre, email, telefono, asunto, mensaje, fecha, hora, estado FROM contactos' . $whereSql . ' ORDER BY fecha DESC, hora DESC LIMIT ? OFFSET ?';
$stmt = $conexion->prepare($sql);
$types2 = $types . 'ii';
$params2 = $params; $params2[] = $items; $params2[] = $offset;
if ($types !== '') { $stmt->bind_param($types2, ...$params2); } else { $stmt->bind_param('ii', $items, $offset); }
$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=contactos.csv');
$out = fopen('php://output', 'w');
fputcsv($out, ['ID','Nombre','Email','Telefono','Asunto','Mensaje','Fecha','Hora','Estado']);
while($r = $result->fetch_assoc()) {
  fputcsv($out, [$r['idcontacto'],$r['nombre'],$r['email'],$r['telefono'],$r['asunto'],$r['mensaje'],$r['fecha'],$r['hora'],$r['estado']]);
}
fclose($out);
$result->free(); $stmt->close(); $conexion->close();
?>