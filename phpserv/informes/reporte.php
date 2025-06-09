<?php
require 'conexion.php';
require "plantilla.php";

date_default_timezone_set("America/Argentina/Buenos_Aires");
setlocale(LC_TIME, 'es_RA.UTF-8','esp');
session_start();

$user = $_SESSION['nombre_usuario'];
$fecha = date("Y-m-d"); // Genera la fecha actual en formato "YYYY-MM-DD"
$hora = date("H:i:s"); // Genera la hora actual en formato "HH:MM:SS"


$desde=$_POST['desde'];
$hasta=$_POST['hasta'];

   $sql = "SELECT p.nombre,p.apellido,a.denunciado,a.causa,a.medida,a.fojas,c.descripcion,a.librodeactas,a.numerodeexpediente,a.fechadeentrada,a.fechadesalida FROM expedientes  AS a INNER JOIN comisarias AS c ON a.codigocomisaria=c.codigocomisaria
    INNER JOIN personas1 AS p ON a.dnidenunciante=p.dnidenunciante WHERE a.fechadeentrada Between '$desde' AND '$hasta' ORDER BY fechadeentrada";

    $sqlreg = "INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario)
    VALUES ('Ninguna', 'Se genero un informe', '$fecha', '$hora', '$user')";

    $mysqli->query($sqlreg);

    $resultado = mysqli_query($mysqli,$sql);
   $pdf = new PDF("P", "mm", "letter");
    $pdf->AliasNbPages();
    $pdf->SetMargins(15, 10, 10);
    $pdf->AddPage();

    $pdf->SetFont("Arial", "B", 9);

    $pdf->Cell(28, 5, "Denunciante", 1, 0, "C");
    $pdf->Cell(26, 5, "Denunciado", 1, 0, "C");
    $pdf->Cell(22, 5, "Causa", 1, 0, "C");
    $pdf->Cell(16, 5, "Medida", 1, 0, "C");
    $pdf->Cell(8, 5, "Foja", 1, 0, "C");
    $pdf->Cell(30, 5, "Comisaria", 1, 0, "C");
    $pdf->Cell(8, 5, "L.A", 1, 0, "C");
    $pdf->Cell(12, 5, utf8_decode("N°.Exp"), 1, 0, "C");
    $pdf->Cell(15, 5, "Fecha.E", 1, 0, "C");
    $pdf->Cell(15, 5, "Fecha.S", 1, 1, "C");

    $pdf->SetFont("Arial", "", 6);

    while ($fila = $resultado->fetch_assoc()) {
        $NyA=$fila['nombre']." ".$fila['apellido'];
        $pdf->Cell(28, 5, utf8_decode($NyA), 1, 0, "C");        
        $pdf->Cell(26, 5, utf8_decode($fila['denunciado']), 1, 0, "C");
        $pdf->Cell(22, 5, utf8_decode($fila['causa']), 1, 0, "C");
        $pdf->Cell(16, 5, utf8_decode($fila['medida']), 1, 0, "C");
        $pdf->Cell(8, 5, utf8_decode($fila['fojas']), 1, 0, "C");
        $pdf->Cell(30, 5, utf8_decode($fila['descripcion']), 1, 0, "C");
        $pdf->Cell(8, 5, utf8_decode($fila['librodeactas']), 1, 0, "C");
        $pdf->Cell(12, 5, utf8_decode($fila['numerodeexpediente']), 1, 0, "C");
        $pdf->Cell(15, 5,date('d/m/Y', strtotime($fila['fechadeentrada'])), 1, 0, "C");
        if ($fila['fechadesalida'] != NULL) {
            
            $pdf->Cell(15, 5, date('d/m/Y', strtotime($fila['fechadesalida'])), 1, 1, "C");
        }
        else{
            $pdf->Cell(15, 5, " ", 1, 1, "C"); 
        }
    }

    $pdf->Output( 'I' ,'Reporte de Expedientes');



?>