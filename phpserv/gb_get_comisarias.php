<?php
header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['nombre_usuario']) || empty($_SESSION['nombre_usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}
require 'connect.php';
$conexion->set_charset('utf8');

$where = [];
$params = [];
$types = '';
if (isset($_GET['q']) && $_GET['q'] !== '') {
    $q = '%' . $_GET['q'] . '%';
    $where[] = '(descripcion LIKE ? OR nrodetelefono LIKE ? OR codigocomisaria LIKE ?)';
    $params[] = $q; $params[] = $q; $params[] = $q;
    $types .= 'sss';
}

$sql = 'SELECT codigocomisaria, nrodetelefono, descripcion FROM comisarias';
if (!empty($where)) { $sql .= ' WHERE ' . implode(' AND ', $where); }
$sql .= ' ORDER BY codigocomisaria ASC';

$stmt = $conexion->prepare($sql);
if (!empty($params)) { $stmt->bind_param($types, ...$params); }
$stmt->execute(); $result = $stmt->get_result();
$registros = []; while ($r = $result->fetch_assoc()) { $registros[] = $r; }
echo json_encode(['status'=>'success','data'=>['registros'=>$registros]]);
$stmt->close(); $conexion->close();