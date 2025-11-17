<?php
header('Content-Type: application/json');
session_start();
require 'connect.php';

$conexion->set_charset('utf8');

// Permitir acceso a cualquier usuario autenticado (rol 'usuario' o 'administrador')
if (!isset($_SESSION['nombre_usuario']) || empty($_SESSION['nombre_usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = isset($_GET['items_per_page']) ? intval($_GET['items_per_page']) : 10;
if ($page < 1) $page = 1;
if ($items_per_page < 1 || $items_per_page > 100) $items_per_page = 10;
$offset = ($page - 1) * $items_per_page;

$where = [];
$params = [];
$types = '';

if (isset($_GET['date_from']) && $_GET['date_from'] !== '') {
    $where[] = 'fecha >= ?';
    $params[] = $_GET['date_from'];
    $types .= 's';
}
if (isset($_GET['date_to']) && $_GET['date_to'] !== '') {
    $where[] = 'fecha <= ?';
    $params[] = $_GET['date_to'];
    $types .= 's';
}
if (isset($_GET['estado']) && $_GET['estado'] !== '') {
    $where[] = 'estado = ?';
    $params[] = $_GET['estado'];
    $types .= 's';
}
if (isset($_GET['q']) && $_GET['q'] !== '') {
    $like = '%' . $_GET['q'] . '%';
    $where[] = '(nombre LIKE ? OR email LIKE ? OR asunto LIKE ? OR mensaje LIKE ?)';
    $params[] = $like; $params[] = $like; $params[] = $like; $params[] = $like;
    $types .= 'ssss';
}

$sql_count = 'SELECT COUNT(*) AS total FROM contactos';
$sql = 'SELECT idcontacto, nombre, email, telefono, asunto, mensaje, fecha, hora, estado FROM contactos';
if (!empty($where)) {
    $cond = implode(' AND ', $where);
    $sql_count .= ' WHERE ' . $cond;
    $sql .= ' WHERE ' . $cond;
}
$sql .= ' ORDER BY fecha DESC, hora DESC LIMIT ? OFFSET ?';
$params2 = $params; $types2 = $types . 'ii'; $params2[] = $items_per_page; $params2[] = $offset;

$stmt_count = $conexion->prepare($sql_count);
if (!empty($params)) { $stmt_count->bind_param($types, ...$params); }
$stmt_count->execute();
$res_count = $stmt_count->get_result();
$row_count = $res_count->fetch_assoc();
$total_records = intval($row_count['total']);
$stmt_count->close();

$stmt = $conexion->prepare($sql);
$stmt->bind_param($types2, ...$params2);
$stmt->execute();
$result = $stmt->get_result();
$registros = [];
while ($r = $result->fetch_assoc()) { $registros[] = $r; }
$stmt->close();

$total_pages = $items_per_page > 0 ? intval(ceil($total_records / $items_per_page)) : 0;

echo json_encode([
    'status' => 'success',
    'message' => 'Contactos obtenidos',
    'data' => [
        'registros' => $registros,
        'total_records' => $total_records,
        'total_pages' => $total_pages,
        'current_page' => $page,
        'items_per_page' => $items_per_page
    ]
]);

$conexion->close();
?>