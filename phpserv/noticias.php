<?php
header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['nombre_usuario']) || empty($_SESSION['nombre_usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}
require 'connect.php';
$conexion->set_charset('utf8');
$sql = "SELECT noticia,imagen,titulo FROM noticias ORDER BY id DESC";
$consulta = mysqli_query($conexion, $sql);
$dato = [];
if ($consulta) { while ($fila = mysqli_fetch_assoc($consulta)) { $dato[] = $fila; } }
echo json_encode(['status'=>'success','data'=>$dato]);
?>