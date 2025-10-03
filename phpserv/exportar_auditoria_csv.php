<?php
// Incluir archivo de conexión
require_once 'conexion.php';

// Establecer encabezados para descarga de CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=auditoria.csv');

// Crear el archivo CSV
$output = fopen('php://output', 'w');

// Establecer el encabezado UTF-8 BOM para que Excel reconozca correctamente los caracteres especiales
fputs($output, "\xEF\xBB\xBF");

// Encabezados del CSV
fputcsv($output, array('ID', 'Fecha y Hora', 'Usuario', 'Tabla', 'Operación', 'Expediente', 'DNI', 'Detalles'));

// Obtener parámetros de filtro
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
$tabla = isset($_GET['tabla']) ? $_GET['tabla'] : '';
$operacion = isset($_GET['operacion']) ? $_GET['operacion'] : '';
$usuario = isset($_GET['usuario']) ? $_GET['usuario'] : '';
$expediente = isset($_GET['expediente']) ? $_GET['expediente'] : '';
$dni = isset($_GET['dni']) ? $_GET['dni'] : '';

// Construir la consulta SQL base
$sql = "SELECT a.*, u.usuario as nombre_usuario 
        FROM auditoria a 
        LEFT JOIN usuarios u ON a.id_usuario = u.id";

// Construir la cláusula WHERE basada en los filtros
$where_clauses = array();
$params = array();

if (!empty($date_from)) {
    $where_clauses[] = "DATE(a.fecha_hora) >= ?"; 
    $params[] = $date_from;
}

if (!empty($date_to)) {
    $where_clauses[] = "DATE(a.fecha_hora) <= ?"; 
    $params[] = $date_to;
}

if (!empty($tabla)) {
    $where_clauses[] = "a.tabla LIKE ?"; 
    $params[] = "%$tabla%";
}

if (!empty($operacion)) {
    $where_clauses[] = "a.operacion = ?"; 
    $params[] = $operacion;
}

if (!empty($usuario)) {
    $where_clauses[] = "u.usuario LIKE ?"; 
    $params[] = "%$usuario%";
}

if (!empty($expediente)) {
    $where_clauses[] = "a.expediente LIKE ?"; 
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
$sql .= " ORDER BY a.fecha_hora DESC";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);

// Vincular parámetros si existen
if (count($params) > 0) {
    $types = str_repeat('s', count($params)); // Todos los parámetros son strings
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Escribir los datos en el CSV
while ($row = $result->fetch_assoc()) {
    $csvRow = array(
        $row['id'],
        $row['fecha_hora'],
        $row['nombre_usuario'] ?? 'N/A',
        $row['tabla'],
        $row['operacion'],
        $row['expediente'] ?? 'N/A',
        $row['dni'] ?? 'N/A',
        $row['detalles']
    );
    fputcsv($output, $csvRow);
}

// Registrar la acción en la tabla de auditoría
$usuario_id = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;
$detalles = "Exportación de registros de auditoría a CSV";

$sql_audit = "INSERT INTO auditoria (id_usuario, tabla, operacion, detalles) VALUES (?, 'auditoria', 'EXPORT', ?)";
$stmt_audit = $conn->prepare($sql_audit);
$stmt_audit->bind_param("is", $usuario_id, $detalles);
$stmt_audit->execute();

// Cerrar conexiones
$stmt->close();
$stmt_audit->close();
$conn->close();