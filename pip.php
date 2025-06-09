<?php
$mysqli = new mysqli("localhost", "root", "martin/123", "Fiscalia");
$sql = "SELECT a.dnidenunciante,a.denunciado,a.causa,a.medida,a.fojas,c.descripcion,a.librodeactas,a.numerodeexpediente,a.fechadeentrada,a.fechadesalida FROM expedientes  AS a INNER JOIN comisarias AS c ON a.codigocomisaria=c.codigocomisaria";
$mysqli->set_charset('utf8');
$resultado = mysqli_query($mysqli,$sql);

echo 'Los datos son: <br>';
while ($fila = $resultado->fetch_assoc()) {

   $datos[]=$fila;

 }
echo json_encode($datos);

?>