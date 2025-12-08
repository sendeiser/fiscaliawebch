<?php
// Incluir archivo de conexión
require_once 'conexion.php';
session_start();
$conn = Conexion::conectar();

// Establecer encabezados para descarga de CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=auditoria.csv');

// Crear el archivo CSV
$output = fopen('php://output', 'w');

// Establecer el encabezado UTF-8 BOM para que Excel reconozca correctamente los caracteres especiales
fputs($output, "\xEF\xBB\xBF");

// Encabezados del CSV
fputcsv($output, array('ID', 'Fecha', 'Hora', 'Usuario', 'Tabla', 'Operación', 'Expediente', 'DNI'));

// Obtener parámetros de filtro
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
$tabla = isset($_GET['tabla']) ? $_GET['tabla'] : '';
$operacion = isset($_GET['operacion']) ? $_GET['operacion'] : '';
$usuario = isset($_GET['usuario']) ? $_GET['usuario'] : '';
$expediente = isset($_GET['expediente']) ? $_GET['expediente'] : '';
$dni = isset($_GET['dni']) ? $_GET['dni'] : '';

// Construir la consulta SQL base
$sql = "SELECT a.id, a.fecha, a.hora, a.usuario, a.tabla_afectada AS tabla, a.operacion, a.num_expediente AS expediente, a.dni 
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

// Escribir los datos en el CSV
while ($row = $result->fetch_assoc()) {
    $csvRow = array(
        $row['id'],
        $row['fecha'],
        $row['hora'],
        $row['usuario'],
        $row['tabla'],
        $row['operacion'],
        $row['expediente'] ?? 'N/A',
        $row['dni'] ?? 'N/A'
    );
    fputcsv($output, $csvRow);
}

// Registrar la acción en la tabla de auditoría (opcional)
$usuario = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'sistema';
$detallesExp = "Exportación de auditoría CSV";
$stmt_audit = $conn->prepare("INSERT INTO auditoria (tabla_afectada, operacion, fecha, hora, usuario, detalles) VALUES ('auditoria','EXPORT',DATE(NOW()),TIME(NOW()),?,?)");
$stmt_audit->bind_param("ss", $usuario, $detallesExp);
$stmt_audit->execute();

// Cerrar conexiones
$stmt->close();
$stmt_audit->close();
$conn->close();
