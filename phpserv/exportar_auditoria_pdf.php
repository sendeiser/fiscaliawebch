<?php
error_reporting(0);
ini_set('display_errors', '0');
// Incluir archivo de conexión y FPDF
require_once 'conexion.php';
session_start();
$conn = Conexion::conectar();
require_once 'informes/fpdf.php';
require_once 'informes/plantilla.php';

// Obtener parámetros de filtro
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
$tabla = isset($_GET['tabla']) ? $_GET['tabla'] : '';
$operacion = isset($_GET['operacion']) ? $_GET['operacion'] : '';
$usuario = isset($_GET['usuario']) ? $_GET['usuario'] : '';
$expediente = isset($_GET['expediente']) ? $_GET['expediente'] : '';
$dni = isset($_GET['dni']) ? $_GET['dni'] : '';

// Construir la consulta SQL base
$sql = "SELECT a.id, a.fecha, a.hora, a.usuario, a.tabla_afectada AS tabla, a.operacion, a.num_expediente AS expediente, a.dni, a.valores_anteriores, a.valores_nuevos 
        FROM auditoria a";

// Construir la cláusula WHERE basada en los filtros
$where_clauses = array();
$params = array();

if (!empty($date_from)) {
    $where_clauses[] = "a.fecha >= ?"; 
    $params[] = $date_from;
}

if (!empty($date_to)) {
    $where_clauses[] = "a.fecha <= ?"; 
    $params[] = $date_to;
}

if (!empty($tabla)) {
    $where_clauses[] = "a.tabla_afectada LIKE ?"; 
    $params[] = "%$tabla%";
}

if (!empty($operacion)) {
    $where_clauses[] = "a.operacion LIKE ?"; 
    $params[] = "%$operacion%";
}

if (!empty($usuario)) {
    $where_clauses[] = "a.usuario LIKE ?"; 
    $params[] = "%$usuario%";
}

if (!empty($expediente)) {
    $where_clauses[] = "a.num_expediente LIKE ?"; 
    $params[] = "%$expediente%";
}

if (!empty($dni)) {
    $where_clauses[] = "a.dni LIKE ?"; 
    $params[] = "%$dni%";
}

// Añadir cláusula WHERE si hay filtros
if (count($where_clauses) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

// Ordenar por fecha y hora descendente
$sql .= " ORDER BY a.fecha DESC, a.hora DESC";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);

// Vincular parámetros si existen
if (count($params) > 0) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Crear PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Título del informe
$pdf->Cell(0, 10, 'Informe de Auditoría', 0, 1, 'C');
$pdf->Ln(5);

// Información de filtros aplicados
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Filtros aplicados:', 0, 1);
$pdf->SetFont('Arial', '', 10);

$filtros = array();
if (!empty($date_from)) $filtros[] = "Fecha desde: $date_from";
if (!empty($date_to)) $filtros[] = "Fecha hasta: $date_to";
if (!empty($tabla)) $filtros[] = "Tabla: $tabla";
if (!empty($operacion)) $filtros[] = "Operación: $operacion";
if (!empty($usuario)) $filtros[] = "Usuario: $usuario";
if (!empty($expediente)) $filtros[] = "Expediente: $expediente";
if (!empty($dni)) $filtros[] = "DNI: $dni";

if (count($filtros) > 0) {
    foreach ($filtros as $filtro) {
        $pdf->Cell(0, 6, $filtro, 0, 1);
    }
} else {
    $pdf->Cell(0, 6, 'Sin filtros aplicados', 0, 1);
}

$pdf->Ln(5);

// Encabezados de la tabla
$pdf->SetFillColor(200, 200, 200);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Fecha y Hora', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Usuario', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Tabla', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Operación', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Expediente', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'DNI', 1, 1, 'C', true);

// Datos de la tabla
$pdf->SetFont('Arial', '', 9);

while ($row = $result->fetch_assoc()) {
    // Verificar si necesitamos una nueva página
    if ($pdf->GetY() > 250) {
        $pdf->AddPage();
        
        // Repetir encabezados en la nueva página
        $pdf->SetFillColor(200, 200, 200);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 10, 'ID', 1, 0, 'C', true);
    $pdf->Cell(50, 10, 'Fecha y Hora', 1, 0, 'C', true);
        $pdf->Cell(25, 10, 'Usuario', 1, 0, 'C', true);
        $pdf->Cell(25, 10, 'Tabla', 1, 0, 'C', true);
        $pdf->Cell(25, 10, 'Operación', 1, 0, 'C', true);
        $pdf->Cell(25, 10, 'Expediente', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'DNI', 1, 1, 'C', true);
        $pdf->SetFont('Arial', '', 9);
    }
    
    $pdf->Cell(15, 10, $row['id'], 1, 0, 'C');
    $pdf->Cell(50, 10, $row['fecha'].' '.$row['hora'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['usuario'], 1, 0, 'L');
    $pdf->Cell(25, 10, $row['tabla'], 1, 0, 'L');
    $pdf->Cell(25, 10, $row['operacion'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['expediente'] ?? 'N/A', 1, 0, 'C');
    $pdf->Cell(30, 10, $row['dni'] ?? 'N/A', 1, 1, 'C');
    
    // Bloques de detalles completos
    if (!empty($row['valores_anteriores'])) {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 6, 'Valores Anteriores:', 1, 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(0, 6, $row['valores_anteriores'], 1);
    }
    if (!empty($row['valores_nuevos'])) {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 6, 'Valores Nuevos:', 1, 1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(0, 6, $row['valores_nuevos'], 1);
    }
}

// Registrar la acción en la tabla de auditoría (opcional)
$usuarioReg = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'sistema';
$detallesReg = "Exportación de auditoría PDF";
$stmt_audit = $conn->prepare("INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, detalles) VALUES ('auditoria','EXPORT',DATE(NOW()),TIME(NOW()),?,?)");
$stmt_audit->bind_param("ss", $usuarioReg, $detallesReg);
$stmt_audit->execute();

// Cerrar conexiones
$stmt->close();
$stmt_audit->close();
$conn->close();

// Salida del PDF
if (function_exists('ob_get_length')) { while (ob_get_level() > 0) { ob_end_clean(); } }
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="auditoria.pdf"');
$pdf->Output('I', 'auditoria.pdf');
exit;
