<?php
header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['nombre_usuario']) || empty($_SESSION['nombre_usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}
require 'connect.php';
$conexion->set_charset('utf8');

$total = 0; $activos = 0; $finalizados = 0; $por_comisaria = []; $top_causas = []; $ultimos30 = 0;

$res = $conexion->query('SELECT COUNT(*) AS c FROM expedientes');
if ($res && ($row = $res->fetch_assoc())) { $total = intval($row['c']); }

$res = $conexion->query('SELECT COUNT(*) AS c FROM expedientes WHERE fechadesalida IS NULL');
if ($res && ($row = $res->fetch_assoc())) { $activos = intval($row['c']); }

$res = $conexion->query('SELECT COUNT(*) AS c FROM expedientes WHERE fechadesalida IS NOT NULL');
if ($res && ($row = $res->fetch_assoc())) { $finalizados = intval($row['c']); }

$res = $conexion->query('SELECT c.descripcion AS comisaria, COUNT(*) AS cantidad FROM expedientes e LEFT JOIN comisarias c ON c.codigocomisaria = e.codigocomisaria GROUP BY c.descripcion ORDER BY cantidad DESC');
if ($res) { while ($r = $res->fetch_assoc()) { $por_comisaria[] = $r; } }

$res = $conexion->query("SELECT causa, COUNT(*) AS cantidad FROM expedientes GROUP BY causa ORDER BY cantidad DESC LIMIT 10");
if ($res) { while ($r = $res->fetch_assoc()) { $top_causas[] = $r; } }

$lim = date('Y-m-d', strtotime('-30 days'));
$stmt = $conexion->prepare('SELECT COUNT(*) AS c FROM expedientes WHERE fechadeentrada >= ?');
$stmt->bind_param('s', $lim); $stmt->execute(); $rr = $stmt->get_result(); if ($rr && ($row = $rr->fetch_assoc())) { $ultimos30 = intval($row['c']); }

echo json_encode(['status'=>'success','data'=>[
    'total_expedientes'=>$total,
    'activos'=>$activos,
    'finalizados'=>$finalizados,
    'por_comisaria'=>$por_comisaria,
    'top_causas'=>$top_causas,
    'ultimos_30_dias'=>$ultimos30
]]);

$conexion->close();