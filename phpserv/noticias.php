<?php
header('Content-Type: application/json');
require 'connect.php';
$conexion->set_charset('utf8');
$sql = "SELECT noticia, imagen, titulo FROM noticias ORDER BY id DESC";
$consulta = mysqli_query($conexion, $sql);
$dato = [];
if ($consulta) { while ($fila = mysqli_fetch_assoc($consulta)) { $dato[] = $fila; } }
echo json_encode($dato);
?>