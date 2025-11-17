<?php
header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['nombre_usuario']) || empty($_SESSION['nombre_usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}
require 'connect.php';
$conexion->set_charset('utf8');

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = isset($_GET['items_per_page']) ? intval($_GET['items_per_page']) : 15;
$offset = ($page - 1) * $items_per_page;

$where = [];
$params = [];
$types = '';

if (isset($_GET['q']) && $_GET['q'] !== '') {
    $q = '%' . $_GET['q'] . '%';
    $where[] = '(p.nombre LIKE ? OR p.apellido LIKE ? OR p.genero LIKE ? OR p.dnidenunciante LIKE ? OR p.nombreabogado LIKE ?)';
    $params[] = $q; $params[] = $q; $params[] = $q; $params[] = $q; $params[] = $q;
    $types .= 'sssss';
}

$sql_count = 'SELECT COUNT(*) AS total FROM personas1 p';
$sql = 'SELECT p.dnidenunciante, p.nombre, p.apellido, p.genero, p.nombreabogado FROM personas1 p';
if (!empty($where)) { $sql_count .= ' WHERE ' . implode(' AND ', $where); $sql .= ' WHERE ' . implode(' AND ', $where); }
$sql .= ' ORDER BY p.dnidenunciante DESC LIMIT ? OFFSET ?';
$params2 = $params; $types2 = $types . 'ii'; $params2[] = $items_per_page; $params2[] = $offset;

$stmt_count = $conexion->prepare($sql_count);
if (!empty($params)) { $stmt_count->bind_param($types, ...$params); }
$stmt_count->execute(); $res_count = $stmt_count->get_result(); $row_count = $res_count->fetch_assoc();
$total_records = intval($row_count['total']); $total_pages = $items_per_page > 0 ? (int)ceil($total_records / $items_per_page) : 0;

$stmt = $conexion->prepare($sql);
if (!empty($params2)) { $stmt->bind_param($types2, ...$params2); }
$stmt->execute(); $result = $stmt->get_result();
$registros = []; while ($r = $result->fetch_assoc()) { $registros[] = $r; }

echo json_encode(['status'=>'success','data'=>['registros'=>$registros,'total_pages'=>$total_pages,'current_page'=>$page,'items_per_page'=>$items_per_page,'total_records'=>$total_records]]);

$stmt->close(); $stmt_count->close(); $conexion->close();